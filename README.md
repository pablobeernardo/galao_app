<h1>Teste Técnico PHP com Laravel</h1>
Este é um teste técnico desenvolvido utilizando o framework Laravel. Ele consiste em uma aplicação web para calcular a quantidade de galões necessários para armazenar um determinado volume de líquido, baseado nas informações fornecidas pelo usuário.
<br>
<h3>Pré-requisitos</h3>
Antes de iniciar, certifique-se de que seu ambiente atenda aos seguintes requisitos:
<ul>
    <li>PHP instalado na sua máquina</li>
    <li>Composer instalado na sua máquina</li>
    <li>XAMPP instalado na sua máquina</li>
</ul>    

<h2>Como executar o projeto</h2>

<ul>
    <li>Clone o repositório do GitHub: git clone https://github.com/pablobeernardo/galao_app.git</li>
    <li>Acesse a pasta do projeto</li>
    <li>Instale as dependências do projeto utilizando o Composer: composer install</li>
    <li>Execute o servidor PHP integrado do Laravel: php artisan serve</li>
    <li>Acesse o servidor Apache através do XAMPP para utilizar a aplicação.</li>
</ul>
<h2>Funcionalidades</h2>
O projeto consiste em duas telas principais:

<h3>Tela de Envio de Informações</h3>
Nesta tela, o usuário pode inserir as informações do galão e das garrafas. As informações são compostas por:

Um campo para inserir a quantidade de litros do galão.
Um campo para inserir um a quantidade de garrafas, e quantidade de litros de cada garrafa.

O aplicativo calcula e faz a lógica para que:
<ul>
<li>O galão deva ser completamente esvaziado com o volume das garrafas;</li>
<li>Procure encher totalmente as garrafas escolhidas;</li>
<li>Quando não for possível encher todas garrafas escolhidas, deixe a menor sobra possível no galão;</li>
<li>Utilize o menor número de garrafas possível;</li>
<li>E salva os resultados na Tela de Registros</li>
</ul>

<h3>Tela de Registros</h3>
Nesta tela, o usuário pode visualizar todos os registros armazenados. Cada registro possui um botão de exportação que permite exportar os dados em CSV, e um botão para apagar cada registro.

<h3>Tecnologias Utilizadas</h3>
<ul>
    <li>Laravel</li>
    <li>PHP</li>
    <li>MySQL</li>
    <li>HTML</li>
    <li>CSS</li>
    <li>JavaScript</li>
</ul>

Autor
Pablo Bernardo
