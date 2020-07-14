# web_scrapping
Desafio proposto pela hostoo

A aplicação atualmente faz um scrap da quantidade de casos e de mortes devido ao Covid-19 no Brasil e em seus Estados, salva no banco de dados, gera um txt e envia o txr para outro servidor via sftp.

- Instalação:

    Após clonar o repositrio, criar um arquivo chamado .env (baseado no .env.example) e rodar o comando:
    
        composer install
        
        php artisan key:generate
        
        php aritsan migrate [(É necessária a instalação de um banco de dados e a configuração da conexão no arquivo .env do projeto para que esse comando execute)].
    
    
    Para que as tasks sejam rodadas é necessário adicionar a seguinte CRON no sistema:
    
        * * * * * cd /<path-to-your-project> && php artisan schedule:run >> /dev/null 2>&1
    
    Caso queira testar os comandos sem a necessidade de aguardar o agendamento, esse sãos os seguintes:
    
        php aritsan scraper:start (A aplicação faz o scraper da página, pega os dados e salva no banco)
        
        php artisan generate:text (A aplicação gera o txt a partir dos dados guardados no banco e envia para outro servidor via sftp, para que isso seja factível,  necessário adicionar a chave ssh no servidor).
    
 
