<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário - Correções Vorazes</title>
    
    <!-- Microsoft Clarity -->
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "spkatd915j");
    </script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #1A1A1A 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 40px 48px;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 720px;
            position: relative;
        }
        
        .tordo-icon {
            position: absolute;
            top: -80px;
            left: 50%;
            transform: translateX(-50%);
            width: 160px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .tordo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        h1 {
            color: #1A1A1A;
            font-size: 34px;
            margin-bottom: 12px;
            text-align: center;
            font-weight: 700;
            margin-top: 90px;
        }
        
        h2 {
            color: #666;
            font-size: 18px;
            font-weight: 400;
            margin-bottom: 36px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        label {
            display: block;
            color: #1A1A1A;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 15px;
        }
        
        input {
            width: 100%;
            padding: 16px 20px;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f5f5f5;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06);
        }
        
        input:focus {
            outline: none;
            background-color: white;
            box-shadow: 0 0 0 3px #FFD93D, inset 0 2px 4px rgba(0, 0, 0, 0.06);
        }
        
        button {
            width: 100%;
            padding: 18px;
            background-color: #1A1A1A;
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
            position: relative;
        }
        
        button::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            background-color: #FF6B35;
            border-radius: 50%;
            transition: all 0.5s ease;
            z-index: 0;
        }
        
        button span {
            position: relative;
            z-index: 1;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        button:hover::after {
            width: 100%;
            height: 100%;
            border-radius: 14px;
        }
        
        button:active {
            transform: translateY(0);
        }
        
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .alert {
            padding: 16px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
            display: none;
        }
        
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .success-screen {
            display: none;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }
        
        .success-screen.show {
            display: block;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 40px;
        }
        
        .success-title {
            color: #1A1A1A;
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .success-message {
            color: #666;
            font-size: 18px;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        
        .whatsapp-button {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background-color: #25D366;
            color: white;
            padding: 20px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3);
        }
        
        .whatsapp-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(37, 211, 102, 0.4);
            background-color: #20BA5C;
        }
        
        .whatsapp-icon {
            width: 28px;
            height: 28px;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tordo-icon">
            <img src="assets/tordo-2.png" alt="Tordo - Correções Vorazes">
        </div>
        
        <div id="formScreen">
            <h1>Não perca a próxima edição do Correções Vorazes com a Milla Borges!</h1>
            <h2>As lives são gratuitas, mas o conteúdo é VIP. Entre no grupo de WhatsApp e receba tudo em tempo real.</h2>
            
            <div id="alert" class="alert"></div>
            
            <form id="formCorrecoes" method="POST" action="salvar.php">
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="telefone">Telefone (WhatsApp)</label>
                    <input type="tel" id="telefone" name="telefone" placeholder="(11) 99999-9999" required>
                </div>
                
                <button type="submit" id="submitBtn"><span>Salvar</span></button>
            </form>
        </div>
        
        <div id="successScreen" class="success-screen">
            <div class="success-icon">✓</div>
            <h1 class="success-title">Parabéns! Cadastro realizado com sucesso!</h1>
            <p class="success-message">
                Agora é só entrar no grupo do WhatsApp para não perder nenhuma correção ao vivo.<br>
                As lives acontecem toda semana e você receberá os avisos em primeira mão!
            </p>
            <a href="https://sndflw.com/i/correcoesvorazes" target="_blank" class="whatsapp-button">
                <svg class="whatsapp-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Entrar no Grupo do WhatsApp
            </a>
        </div>
    </div>

    <script>
        document.getElementById('formCorrecoes').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitBtn');
            const alertDiv = document.getElementById('alert');
            
            // Disable button during submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Salvando...</span>';
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('salvar.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Hide form and show success screen
                    document.getElementById('formScreen').style.display = 'none';
                    document.getElementById('successScreen').classList.add('show');
                    
                    // Scroll to top smoothly
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    alertDiv.className = 'alert error show';
                    alertDiv.textContent = result.message || 'Erro ao salvar os dados.';
                }
            } catch (error) {
                alertDiv.className = 'alert error show';
                alertDiv.textContent = 'Erro ao processar a solicitação.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>Salvar</span>';
                
                // Hide alert after 5 seconds
                setTimeout(() => {
                    alertDiv.classList.remove('show');
                }, 5000);
            }
        });
        
        // Phone mask
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 11) {
                    if (value.length <= 2) {
                        value = `(${value}`;
                    } else if (value.length <= 7) {
                        value = `(${value.slice(0,2)}) ${value.slice(2)}`;
                    } else {
                        value = `(${value.slice(0,2)}) ${value.slice(2,7)}-${value.slice(7)}`;
                    }
                }
                e.target.value = value;
            }
        });
    </script>
</body>
</html>