<?php
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ActiveCampaign Configuration
define('AC_API_KEY', 'ef1acfb06bf366366a44dd9444dcc92206e16fea7203a42256258695d30bd5d5dcac0384');
define('AC_API_URL', 'https://profmillaborges.api-us1.com');
define('AC_LIST_ID', '25'); // Correções Vorazes

// Define the data directory and file
$dataDir = __DIR__ . '/data';
$dataFile = $dataDir . '/inscricoes.json';

// Create data directory if it doesn't exist
if (!file_exists($dataDir)) {
    if (!mkdir($dataDir, 0777, true)) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao criar diretório de dados'
        ]);
        exit;
    }
}

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método não permitido'
    ]);
    exit;
}

// Get and validate form data
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';

// Validation
if (empty($nome) || empty($email) || empty($telefone)) {
    echo json_encode([
        'success' => false,
        'message' => 'Por favor, preencha todos os campos'
    ]);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Email inválido'
    ]);
    exit;
}

// Clean phone number (remove formatting)
$telefoneClean = preg_replace('/\D/', '', $telefone);

// Set timezone to Brazil
date_default_timezone_set('America/Sao_Paulo');

// Function to send contact to ActiveCampaign
function sendToActiveCampaign($email, $nome, $telefone) {
    // Create contact
    $contactData = [
        'contact' => [
            'email' => $email,
            'firstName' => explode(' ', $nome)[0],
            'lastName' => trim(substr($nome, strpos($nome, ' ') + 1)),
            'phone' => $telefone
        ]
    ];
    
    // First, create or update the contact
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, AC_API_URL . '/api/3/contact/sync');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($contactData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Api-Token: ' . AC_API_KEY,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200 && $httpCode !== 201) {
        error_log('ActiveCampaign contact sync error: ' . $response);
        return false;
    }
    
    $result = json_decode($response, true);
    $contactId = $result['contact']['id'] ?? null;
    
    if (!$contactId) {
        error_log('ActiveCampaign: No contact ID returned');
        return false;
    }
    
    // Add contact to list
    $listData = [
        'contactList' => [
            'list' => AC_LIST_ID,
            'contact' => $contactId,
            'status' => 1 // 1 = subscribed
        ]
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, AC_API_URL . '/api/3/contactLists');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($listData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Api-Token: ' . AC_API_KEY,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200 && $httpCode !== 201) {
        // Contact might already be in the list, which is okay
        error_log('ActiveCampaign list add warning: ' . $response);
    }
    
    return true;
}

// Create new registration
$novaInscricao = [
    'id' => uniqid(),
    'nome' => $nome,
    'email' => $email,
    'telefone' => $telefone,
    'telefone_limpo' => $telefoneClean,
    'data_cadastro' => date('Y-m-d H:i:s'),
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'activecampaign_status' => 'pending'
];

// Load existing data
$inscricoes = [];
if (file_exists($dataFile)) {
    $jsonContent = file_get_contents($dataFile);
    if ($jsonContent !== false) {
        $decoded = json_decode($jsonContent, true);
        if (is_array($decoded)) {
            $inscricoes = $decoded;
        }
    }
}

// Check if email already exists
$emailJaExiste = false;
foreach ($inscricoes as $inscricao) {
    if ($inscricao['email'] === $email) {
        $emailJaExiste = true;
        break;
    }
}

// If email already exists, return success without saving again
if ($emailJaExiste) {
    echo json_encode([
        'success' => true,
        'message' => 'Você já está cadastrado! Acesse o grupo do WhatsApp.',
        'data' => [
            'already_registered' => true
        ]
    ]);
    exit;
}

// Send to ActiveCampaign (don't block if it fails)
$acSuccess = sendToActiveCampaign($email, $nome, $telefone);

// Update ActiveCampaign status based on result
$novaInscricao['activecampaign_status'] = $acSuccess ? 'success' : 'failed';
$novaInscricao['activecampaign_sync_date'] = date('Y-m-d H:i:s');

// Add new registration
$inscricoes[] = $novaInscricao;

// Save to file
$jsonFlags = JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
if (file_put_contents($dataFile, json_encode($inscricoes, $jsonFlags)) !== false) {
    // Create CSV backup
    $csvFile = $dataDir . '/inscricoes.csv';
    $csvHandle = fopen($csvFile, 'w');
    
    if ($csvHandle) {
        // Write CSV header
        fputcsv($csvHandle, ['ID', 'Nome', 'Email', 'Telefone', 'Data Cadastro', 'ActiveCampaign Status']);
        
        // Write all registrations
        foreach ($inscricoes as $inscricao) {
            fputcsv($csvHandle, [
                $inscricao['id'],
                $inscricao['nome'],
                $inscricao['email'],
                $inscricao['telefone'],
                $inscricao['data_cadastro'],
                $inscricao['activecampaign_status'] ?? 'unknown'
            ]);
        }
        
        fclose($csvHandle);
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Cadastro realizado com sucesso! Em breve você receberá o link do grupo no WhatsApp.',
        'data' => [
            'id' => $novaInscricao['id'],
            'total_inscricoes' => count($inscricoes)
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao salvar os dados. Por favor, tente novamente.'
    ]);
}
?>