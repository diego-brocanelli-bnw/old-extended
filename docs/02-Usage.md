# 2. Como Usar

## Acessando o Old Input

O pacote Old Extended foi desenvolvido para extender propósito do helper **Old**, adicionando mais funcionalidades e tornando a programação do formulário mais limpa e fácil de entender.

> **Nota:** Para explicar as funcionalidades, consideraremos a implementação de um formulário para edição, contendo uma variável chamada ***$model***, que contém todos os campos provenientes do banco de dados.

Assim como o old, as funcionalidades podem ser implementadas de duas formas:

* através dos helpers (geralmente dentro de templates blade);
* através do objeto da requisição ( $request->old() )

> **Dica**: veja na [documentação oficial](https://laravel.com/docs/5.6/requests#old-input) os exemplos de como usar o old do objeto \Illuminate\Http\Request.

Numa situação normal, os helpers serão usados diretamente nos templates blade:

```html
<form action="/users/update" method="post">

    <div>

        <label>Nome</label>
    
        <input type="text" name="name" value="{{ old('name', $model->name) }}">

    </div>

    <div>

        <label>Data de Nascimento</label>
    
        <input type="text" name="birth" value="{{ old_date('birth', $model->birth) }}">

    </div>

    <div>

        <label>Receber Notificações</label>
    
        <br>

        <input type="checkbox" name="notify" value="yes" {{ old_check('notify', 'yes', $model->notify) }}>

    </div>
</form>
```

Todavia, poderão existir casos mais específicos onde as funcionalidades precisarão ser invocadas de dentro do controlador. Por isso é importante entender o proceso de requisição. Isso veremos a seguir!

## O Objeto Request

O objeto padrão para requisições é o ***\Illuminate\Http\Request***. Na seção [Accessing The Request](https://laravel.com/docs/5.6/requests#accessing-the-request) da documentação oficial existe um exemplo de como acessar a requisição a partir de um método do controlador. Para facilitar o entendimento, observe o exemplo abaixo:

```php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Formulário de Edição
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        // Obtém os dados do usuário no banco de dados
        $model = \App\User::find($id);

        // O usuário já digitou o nome?
        // SIM: o old devolve o valor digitado,
        // NÃO: o old devolve o valor do banco de dados
        $name_value = $request->old('name', $model->name);
        // dá na mesma acessar através do helper:
        $name_value = old('name', $model->name);
        
        return view('form.edit')->with('name', $name_value)        
    }
    
    /**
     * Salva os dados do formulário
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // Se o nome especificado tiver mais de 8 caracteres,
        // o campo será invalidado e o usuário será redirecionado
        // automaticamente para o Formulário de Edição. 
        // Neste processo, os dados já digitados são armazenados 
        // numa sessão temporária para serem acessados através 
        // do helper old()
        $request->validate([
            'name' => 'required|max:8',
        ]);

        // Atualiza os dados do usuário
        $model = \App\User::find($id);
        $model->fill($request->all());
        $model->save();

        // Gravado com sucesso, 
        // redireciona o usuário para a lista de usuários
        return redirect()->route('users.index');
    }
} 
```

No exemplo acima, os comentários explicam o fluxo que acontece do processo de validação dos dados submetidos pelo formulário de edição. Perceba que o objeto ***Request*** é retornado nos dois métodos (edit e update). O parâmetro $id é adicionado pela rota (Ex: /usuarios/editar/{23}) mas o parâmetro $request é adicionado automaticamente pelo Laravel através de [Injeção Automática](https://laravel.com/docs/5.6/container#automatic-injection) de objetos.

O objeto Request possui o método ***$request->old***, que faz a mesma coisa que o helper ***old***.

Entendido isso, podemos prosseguir.

## Com o objeto ExtendedRequest

O pacote Old Extended oferece uma clase própria para tratamento de Requisições para formulários, trata-se do ***OldExtended\Http\Requests\ExtendedRequest***.

Basicamente, é uma classe que extende Request, implementando os métodos adicionais e tratamentos especiais para as informações de data e hora.

Para usar o objeto ExtendedRequest, basta trocar as incidências ao objeto Request encontradas no exemplo anterior:

```php

namespace App\Http\Controllers;

use OldExtended\Http\Requests\ExtendedRequest;

class UserController extends Controller
{
    public function edit(ExtendedRequest $request, $id)
    {
        // Agora é possivel acessar os métodos especiais
        $request->oldOption();
        $request->oldRadio();
        $request->oldCheck();
        $request->oldDate();
        $request->oldDatetime();

        // ...       
    }
    
    public function update(ExtendedRequest $request, $id)
    {
        $request->dateTransform();
        // ...
    }
} 
```

## Sem o Objeto ExtendedRequest

O uso de ExtendedRequest nem sempre é obrigatório, pois você pode usar a maioria das funcionalidades sem a necessidade dele, bastando usar os helpers disponíveis:

```php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(Request $request, $id)
    {
        // Agora é possivel acessar os métodos especiais
        $old_option();
        $old_radio();
        $old_check();
        $old_date();
        $old_datetime();

        // ...       
    }
    
    public function update(Request $request, $id)
    {
        $date_transform();
        // ...
    }
} 
```

## old_option

```php
old_option($key, $option_value = null, $stored_value = null);
```

Campos do tipo select possuem opções, que ao serem escolhidas pelo usuário, são marcadas com o atributo ***selected***. 

Usando o ***old padrão*** do Laravel, ficaria assim:

```html
<div>

    <label>Categoria</label>
    
    <select name="category_id">

        @foreach($categories as $item)

            @if( old('category_id', $item->id) === $model->category_id )

                <option value="{{ $item->id }}" selected>
                {{ $item->label }}
                </option>
                
            @else

                <option value="{{ $item->id }}">
                {{ $item->label }}
                </option>

            @endif
        
        @endforeach
        
    </select>

</div>
```

Com o ***old_option***, por ficar mais conciso, basta adicionar diretamente no local onde o selected deverá aparecer:

```html
<div>

    <label>Categoria</label>
    
    <select name="category_id">

        @foreach($categories as $item)
        
            <option value="{{ $item->id }}" {{ old_option('category_id', $item->id, $model->category_id) }}>
            {{ $item->label }}
            </option>
        
        @endforeach
        
    </select>

</div>
```

## old_radio

```php
old_radio($key, $input_value = null, $stored_value = null);
```

Campos input do tipo radio são opções, que ao serem clicadas pelo usuário, são marcadas com o atributo ***checked***. 

Usando o ***old padrão*** do Laravel, ficaria assim:

```html
<div>

    <label>Status</label>

    <br>

    @if(old('status') == 'active' || $model->status == 'active')
    
        <input type="radio" name="status" value="active" checked>
        
    @else
    
        <input type="radio" name="status" value="active">
        
    @endif

    <br>

    @if(old('status') == 'inactive' || $model->status == 'inactive')
    
        <input type="radio" name="status" value="inactive" checked>
        
    @else
    
        <input type="radio" name="status" value="inactive">
        
    @endif
    
</div>
```

Com o ***old_radio***, por ficar mais conciso, basta adicionar diretamente no local onde o checked deverá aparecer:

```html
<div>

    <label>Status</label>

    <br>
    
    <input type="radio" name="status" value="active" {{ old_radio('status', 'active', $model->status) }}>
    
    <br>
    
    <input type="radio" name="status" value="inactive" {{ old_radio('status', 'inactive', $model->status) }}>
    
</div>
```


## old_check

```php
old_check($key, $input_value = null, $stored_value = null);
```

Campos input do tipo checkbox são opções, que ao serem clicadas pelo usuário, são marcadas com o atributo ***checked***. 

Usando o ***old padrão*** do Laravel, ficaria assim:

```html
<div>

    <label>Receber Notificações</label>
    
    <br>

    @if(old('notify') == 'yes' || $model->notify == 'yes')
    
        <input type="checkbox" name="notify" value="yes" checked>
        
    @else
    
        <input type="checkbox" name="notify" value="yes">
        
    @endif

</div>
```

Com o ***old_check***, por ficar mais conciso, basta adicionar diretamente no local onde o checked deverá aparecer:

```html
<div>

    <label>Receber Notificações</label>
    
    <br>

    <input type="checkbox" name="notify" value="yes" {{ old_check('notify', 'yes', $model->notify) }}>

</div>
```

## Escopo de old_date e old_date_time

Usando o ExtendedRequest, os valores dos helpers old_date e old_date_time, especificados no formulário serão tratados automaticamente e não será necessário fazer nada manualmente. 

Caso não se use o ExtendedRequest, optando por usar apenas os helpers, a mesma afirmação não é verdade!! Isso porque estes dois helpers em especial possuem uma rotina que trata os formatos das datas, transportando do formulário para o banco de dados e vice-versa.

Em outras palavras, na configuração padrão, as datas do formulário sempre serão exibidas como '10/01/1980' e gravadas como '1980-01-10'. Esta conversão e feita pelo ExtendedRequest, usando o helper date_tranform nos momentos adequados.

Nos exemplos abaixo, veja como implementar usando ou não usando o ExtendedRequest e decida você mesmo qual implementação efetuar:


## old_date

```php
old_date($key, $stored_value = null, $stored_format = 'Y-m-d', $show_format = 'd/m/Y');
```

O helper ***old_date*** funciona como o old padrão do Laravel, porém com transformação de datas. 

É muito comum, nos campos de formulário, utilizar máscaras para datas no formato brasileiro (10/01/1980), e no momento da gravação, transformá-las para o formato de banco de dados (1980-01-10). O ***old_date*** faz estre trabalho automaticamente. Para usar é preciso dois passos:

### Passo 1: 

O primeiro passo é declarar o old_date normalmente no blade:

```html
<div>

    <label>Data de Nascimento</label>
    
    <input type="text" name="birth" value="{{ old_date('birth', $model->birth) }}">

</div>
```

O código acima recebe o formato ***10/01/1980*** do formulário e transforma para ***1980-01-10*** no momento da gravação.

É possível também especificar o formato de gravação e o formato do formulário, bastando acrescentar parâmetros adicionais ao helper:

```html
<div>

    <label>Data de Nascimento</label>
    
    <input type="text" name="birth" value="{{ old_date('birth', $model->birth, 'Y-m-d', 'd/m/Y') }}">

</div>
```

### Passo 2 (usando o ExtendedRequest): 

O segundo passo é personalizar a requisição recebida pelo formulário no controlador. Isso é necessário para que o old_date possa transformar as datas configuradas no blade sem fazer rotinas adicionais.

Basta trocar a invocação normal nos métodos de gravação de ***\Illuminate\Http\Request*** para ***\OldExtended\Http\Requests\ExtendedRequest***:

```php
use OldExtended\Http\Requests\ExtendedRequest;

class ExampleController extends Controller
{
    public function update(ExtendedRequest $form, $id)
    {
        // Campos de data são detectados e convertidos 
        // automaticamente de 10/01/1980 para 1980-01-10
        // Não é preciso fazer nada!!
        echo $form->birth; // exibe: 1980-01-10

        $model = \App\User::find($id);
        $model->fill($form->all());
        $model->save();

        // ...
    }
}
```
O objeto ExtendedRequest detecta automaticamente os campos corretos e os transforma no momento da requisição com base nos parâmetros de transformação passados no formulário com o helper ***old_date***.

### Passo 2 (sem usar o ExtendedRequest): 

Para fazer o segundo passo sem usar o ExtendedRequest, será necessário tratar as datas manualmente antes de gravar no banco de dados:

```php
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function update(Request $form, $id)
    {
        // Campos de data são recebidos do jeito 
        // que estão no formulário, pois não são tratados!
        echo $form->birth; // exibe: 10/01/1980

        // Converte a data de '10/01/1980' para '1980-01-10'
        $new_date = date_transform($form->birth, 'd/m/Y', 'Y-m-d');

        // Atualiza a data na requisição
        $form->request->set('birth', $new_date);

        // Agora é possível salvar normalmente
        $model = \App\User::find($id);
        $model->fill($form->all());
        $model->save();

        // ...
    }
}
```

## old_datetime

```php
old_datetime($key, $stored_value = null, $stored_format = 'Y-m-d H:i:s', $show_format = 'd/m/Y H:i:s');
```

O old_datetime faz a mesmíssica coisa que o old_date, pois é um alias. A única diferença se encontra nos formatos padrões, que já são predefinidos com as horas, minutos e segundos.

Em outras palavras:

```html
<input type="text" name="birth" value="{{ old_datetime('birth', $model->birth) }}">
```

é o mesmo que:

```html
<input type="text" name="birth" value="{{ old_date('birth', $model->birth, 'Y-m-d H:i:s', 'd/m/Y H:i:s') }}">
```

## date_transform

Transforma uma data de um formato para outro. Por exemplo, '10/01/1980' para '1980-01-10'.

```php
date_transform($date_value, $format_origin = 'd/m/Y H:i:s', $format_destiny = 'Y-m-d H:i:s');
```

## Sumário

1. [Sobre](00-Home.md)
2. [Instalação](01-Installation.md)
3. [Como Usar](02-Usage.md)
4. [Exemplos](03-Examples.md)
5. [Extras](04-Extras.md)

...