# Desafio Linx

Desafio de recrutamento para a Linx, onde deve ser feito uma API <em>stateless</em> em PHP de acordo com 
os seguintes critérios:
                                     
Esta API deve conter três rotas:
 
- GET http://localhost/posts/1 - Retorna um único post identificado pelo id, seu autor, 
e uma lista de seus comentários e seus respectivos autores.

- GET http://localhost/posts - Retorna uma lista de todos os posts, seus autores, seus 
comentários e os autores dos comentários.

- POST http://localhost/posts - Cria um novo post, com seu autor. Um novo autor deve ser 
inserido, se esse não existir.

## Exxecutando a API

Para executar a API, é necessário ter instalado na máquina:
- [<strong>Git</strong>](https://git-scm.com/) - necessário para fazer o download do código;
- [<strong>Docker</strong>](https://www.docker.com/) - A API está preparada para ser executada 
utilizando Docker, sem a necessidade de instalar as demais dependências para execução do projeto;
- [<strong>Docker Compose</strong>](https://docs.docker.com/compose/) - Permite a execução do 
projeto de forma simples e prática. Facilita também o import das imagens docker necessárias.


Com os requisitos instalados, seguem os passos:

1. Clone ou baixe o projeto do repositório Git

<code>git clone </code>


Run this command from the directory in which you want to install your new Slim Framework application.

    php composer.phar create-project slim/slim-skeleton [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

To run the application in development, you can run these commands 

	cd [my-app-name]
	php composer.phar start

Run this command in the application directory to run the test suite

	php composer.phar test

That's it! Now go build something cool.





USAR QUANDO QPARECE: api-linx-test_composer_1 exited with code 0