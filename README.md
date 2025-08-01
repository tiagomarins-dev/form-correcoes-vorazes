# Formulário Correções Vorazes

Sistema de captura de leads para o projeto Correções Vorazes da prof. Milla Borges.

## Requisitos

- Docker
- Docker Compose

## Como executar

1. Clone ou baixe os arquivos para sua máquina

2. No terminal, navegue até a pasta do projeto:
```bash
cd /caminho/para/form_correcoes_vorazes
```

3. Inicie o container Docker:
```bash
docker-compose up -d
```

4. Acesse o formulário em:
```
http://localhost:6050
```

## Arquivos importantes

- `index.php` - Página principal com o formulário
- `salvar.php` - Script PHP que processa e salva os dados
- `data/inscricoes.json` - Arquivo JSON com todos os cadastros
- `data/inscricoes.csv` - Backup em CSV dos cadastros

## Parar o sistema

Para parar o container:
```bash
docker-compose down
```

## Funcionalidades

- Formulário responsivo com validação
- Máscara de telefone automática
- Salvamento em JSON e CSV
- Validação de email duplicado
- Feedback visual de sucesso/erro
- Animações suaves

## Dados salvos

Para cada inscrição são salvos:
- ID único
- Nome
- Email
- Telefone (formatado e limpo)
- Data e hora do cadastro
- IP do usuário