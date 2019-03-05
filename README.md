# api-linx-chalenge

Desafio de recrutamento para a Linx, onde deve ser feito uma API <em>stateless</em> em PHP de acordo com 
os seguintes critérios:
                                     
Esta API deve conter três rotas:
 
- GET http://localhost/posts/1 - Retorna um único post identificado pelo id, seu autor, 
e uma lista de seus comentários e seus respectivos autores.

- GET http://localhost/posts - Retorna uma lista de todos os posts, seus autores, seus 
comentários e os autores dos comentários.

- POST http://localhost/posts - Cria um novo post, com seu autor. Um novo autor deve ser 
inserido, se esse não existir.

### Exxecutando a API

Para executar a API, é necessário ter instalado na máquina:
- [<strong>Git</strong>](https://git-scm.com/) - necessário para fazer o download do código;
- [<strong>Docker</strong>](https://www.docker.com/) - A API está preparada para ser executada 
utilizando Docker, sem a necessidade de instalar as demais dependências para execução do projeto;
- [<strong>Docker Compose</strong>](https://docs.docker.com/compose/) - Permite a execução do 
projeto de forma simples e prática. Facilita também o import das imagens docker necessárias.


Com os requisitos instalados, seguem os passos:

1 - No terminal, clone o projeto do repositório Git
    
    git clone https://github.com/danieelxavier/api-linx-challenge.git

2 - Entre no diretório do projeto

3 - Execute o comando ``docker-compose up`` para iniciar o processo de criação do container,
download de dependências e execução do serviço.

4 - Você deve aguardar todas as dependências serem carregadas para que a API funcione, esse 
processo pode demorar poucos minutos. O carregamento das dependências terminam quando
aparece a mensagem ``composer exited with code 0``.


<strong>Importante:</strong> O serviço roda na porta 80, tenha a certeza que, 
na sua máquina, não tenha nenhum outro serviço utilizando a porta 80, como lamp, apache, etc.


####Observações

- Os objetos de comentários dos posts obtidos pelo JSON Place holder não possuem referências para
usuários, não sendo possível inserir o objeto de author no objetos de comentários.


####Desafio Bônus

- Descreva a infra e como sua API deveria ser colocada em produção.

> Para ser colocada em produção, a API precisaria de um servidor com Docker e Docker compose
 instalados, a API vai ao ar apenas utilizando o comando do Dcoker Compose, onde são gerados 
 automaticamente todas as imagens Docker, volumes e containers, assim como a obtençaõ de todas
 as dependências através do composer. O projeto base da API foi baseado no FRamework Slim, 
 que é uma ótima ferramenta para geração de aplicações de API em PHP, com ótima estrutura de 
 organização. Entre as dependências, carregadas pelo composer, estão ferramentas para geração 
 de logs, de requisição HTTP e de validação de parâmetros.<br> 
 Esse servidor pode ser uma máquina local com boa conexão 
 ou uma máquina na nuvem, podendo contratar de algum serviço especializado. 


- Quais as estratégias para escalar sua API, num cenário de muitos requests?

> Há dois principais quesitos para se preocupar quanto à escalabilidade da aplicação, a 
preocupação com a utilização de cache e a clusterização do serviço.<br><br>
A idéia de cache pode ser implementado em diversos pontos do projeto, melhorando o 
desempenho do hardware existente. Há alguns tipos de soluções de cache que podem ser 
utilizadas: o '<strong><em>mencache</em></strong>' realiza cache de objetos que pode 
ser distribuída em múltiplos servidores; o '<strong><em>Alternative PHP Cache</em></strong>' 
pode cachear os códigos de operação de funções PHP que são executadas frequentemente;
Outra solução é o o '<strong><em>Zend Opcache</em></strong>', que armazena o bytecode 
dos scripts pré-compilados em uma memória compartilhada e elimina a leitura de disco e 
compilação para acessos futuros.<br><br>
Entretanto, o principal quesito para que seja possível conseguir uma boa escala é a utilização
de cluster, permitindo, de forma simples, adicionar novos nós do serviço para realizar 
balanceamento de carga. Pensar em clusterização é imprescindível para um bom escalonamento 
horizontal de serviços.


