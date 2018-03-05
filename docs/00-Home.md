# Laravel Old Extended

## Sobre o Old Input

Na [documentação oficial do Laravel](https://laravel.com/docs/5.6/requests#old-input), encontra-se o método ***old***, disponível no objeto Request, responsável pelas informações da requisição. Para facilitar o uso deste método, existe um helper global com o mesmo nome ***old***, ideal para ser chamado dentro de templates blade.

Explicando resumidamente, o ***old*** devolve o valor de um campo após a última submissão do formulário.

Imagine que em um formulário alguém digite qualquer coisa em um input cujo nome seja ***email***. Após digitar e submeter o formulário, se o e-mail for classificado como inválido, o proceso de validação ira redirecionar o usuário de volta para o formulário e também disponibilizará os dados digitados para que o usuário não precise digitar tudo de novo.

Estes dados já digitados são acessados através do old, bastando especificar o nome do campo a ser devolvido:

```html
<input type="text" name="email" value="{{ old('email') }}">
```

O atributo ***value*** vai receber o texto que o usuário tinha digitado antes da submissão do formulário, ou um valor vazio (null), se o usuário não digitou nada.

É possível especificar um segundo parâmetro com o valor padrão, caso o usuário não digitar nada:

```html
<input type="text" name="email" value="{{ old('email', 'meuemail@gmail.com') }}">
```

> **Nota:** Especificar um valor padrão é muito útil para formulários de edição, onde este valor deverá ser proveniente do banco de dados


## Sobre o Old Extended

Como o nome já diz, trata-se de uma ***Extensão do Old*** original do Laravel. O pacote provê helpers adicionais para o desenvolvimento de formulários.

O objetivo é facilitar a programação de templates para formulários de forma elegante e concisa :)

Entre os helpers disponíveis estão:

* **old_option**: Adiciona o atributo *selected* em campos select;
* **old_radio**: Adiciona o atributo *checked* em campos input do tipo radio;
* **old_check**: Adiciona o atributo *checked* em campos input do tipo checkbox;
* **old_date**: Trata o valor de datas, gerenciando os formatos de entrada e saída;
* **old_datetime**: um alias para old_date;
* **date_transform**: Transforma uma data de um formato para outro.

## Sumário

1. [Sobre](00-Home.md)
2. [Instalação](01-Installation.md)
3. [Como Usar](02-Usage.md)
4. [Exemplos](03-Examples.md)
5. [Extras](04-Extras.md)
  