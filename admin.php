<?php
session_start();

// Set timezone to Brazil
date_default_timezone_set('America/Sao_Paulo');

// Define the admin password
define('ADMIN_PASSWORD', '10763064700');

// Check if user is logged in
$isLoggedIn = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        $isLoggedIn = true;
    } else {
        $loginError = 'Senha incorreta!';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Load data if logged in
$inscricoes = [];
$totalInscritos = 0;
$totalSyncSuccess = 0;
$totalSyncFailed = 0;
$totalSyncPending = 0;

if ($isLoggedIn) {
    $dataFile = __DIR__ . '/data/inscricoes.json';
    if (file_exists($dataFile)) {
        $jsonContent = file_get_contents($dataFile);
        if ($jsonContent !== false) {
            $decoded = json_decode($jsonContent, true);
            if (is_array($decoded)) {
                $inscricoes = array_reverse($decoded); // Show newest first
                $totalInscritos = count($inscricoes);
                
                // Count ActiveCampaign sync status
                foreach ($decoded as $inscricao) {
                    $status = $inscricao['activecampaign_status'] ?? 'unknown';
                    if ($status === 'success') {
                        $totalSyncSuccess++;
                    } elseif ($status === 'failed') {
                        $totalSyncFailed++;
                    } elseif ($status === 'pending') {
                        $totalSyncPending++;
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Correções Vorazes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .login-container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #1A1A1A;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        input[type="password"] {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
        }
        
        input[type="password"]:focus {
            outline: none;
            border-color: #FF6B35;
        }
        
        button {
            width: 100%;
            padding: 14px;
            background-color: #FF6B35;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #e55a2b;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .admin-header {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header h1 {
            color: #1A1A1A;
            font-size: 28px;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .stat-card h3 {
            color: #666;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        
        .stat-card .number {
            color: #FF6B35;
            font-size: 48px;
            font-weight: 700;
        }
        
        .data-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .table-header {
            padding: 20px 30px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .table-header h2 {
            color: #1A1A1A;
            font-size: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        .logout-btn {
            background-color: #dc3545;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 6px;
        }
        
        .logout-btn:hover {
            background-color: #c82333;
        }
        
        .download-btn {
            background-color: #28a745;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 6px;
            margin-right: 10px;
            text-decoration: none;
            display: inline-block;
        }
        
        .download-btn:hover {
            background-color: #218838;
        }
        
        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-secondary {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        @media (max-width: 768px) {
            .admin-header {
                flex-direction: column;
                gap: 20px;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            table {
                min-width: 600px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$isLoggedIn): ?>
            <div class="login-container">
                <h1>Área Administrativa</h1>
                
                <?php if (isset($loginError)): ?>
                    <div class="error"><?php echo $loginError; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="form-group">
                        <label for="password">Senha de Acesso</label>
                        <input type="password" id="password" name="password" required autofocus>
                    </div>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        <?php else: ?>
            <div class="admin-header">
                <h1>Correções Vorazes - Inscritos</h1>
                <div class="actions">
                    <a href="data/inscricoes.csv" download class="download-btn">Download CSV</a>
                    <a href="data/inscricoes.json" download class="download-btn">Download JSON</a>
                    <a href="?logout=1" class="logout-btn">Sair</a>
                </div>
            </div>
            
            <div class="stats">
                <div class="stat-card">
                    <h3>Total de Inscritos</h3>
                    <div class="number"><?php echo $totalInscritos; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Enviados ao ActiveCampaign</h3>
                    <div class="number" style="color: #28a745;"><?php echo $totalSyncSuccess; ?></div>
                </div>
                <?php if ($totalSyncFailed > 0): ?>
                <div class="stat-card">
                    <h3>Falhas no Envio</h3>
                    <div class="number" style="color: #dc3545;"><?php echo $totalSyncFailed; ?></div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="data-table">
                <div class="table-header">
                    <h2>Lista de Inscritos</h2>
                </div>
                
                <?php if (empty($inscricoes)): ?>
                    <div class="empty-state">
                        <h3>Nenhuma inscrição ainda</h3>
                        <p>As inscrições aparecerão aqui assim que forem realizadas.</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Data de Cadastro</th>
                                    <th>ActiveCampaign</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inscricoes as $inscricao): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($inscricao['nome']); ?></td>
                                        <td><?php echo htmlspecialchars($inscricao['email']); ?></td>
                                        <td><?php echo htmlspecialchars($inscricao['telefone']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($inscricao['data_cadastro'])); ?></td>
                                        <td>
                                            <?php 
                                            $status = $inscricao['activecampaign_status'] ?? 'unknown';
                                            if ($status === 'success'): ?>
                                                <span class="badge badge-success">✓ Enviado</span>
                                            <?php elseif ($status === 'failed'): ?>
                                                <span class="badge badge-danger">✗ Falhou</span>
                                            <?php elseif ($status === 'pending'): ?>
                                                <span class="badge badge-warning">⏳ Pendente</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">? Desconhecido</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>