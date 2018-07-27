<?php
/**
 * @see       https://github.com/rpdesignerfly/old-extended
 * @copyright Copyright (c) 2018 Ricardo Pereira Dias (https://rpdesignerfly.github.io)
 * @license   https://github.com/rpdesignerfly/old-extended/blob/master/license.md
 */

declare(strict_types=1);

namespace OldExtended\Http\Controllers;

use Illuminate\Http\Request;
use OldExtended\Http\Requests\ExtendedRequest;

class ExampleController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('old-extended::edit')
            ->with('model', \App\User::find(1));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $form
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExtendedRequest $form)
    {
        // Para testar o old_date()
        // dd($form->all());

        // Não faz nada e volta para o formulário.
        // Operação apenas para testar os 'olds'
        return back()->withInput($form->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $form
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $form)
    {
        session()->forget('_flash.old');
        session()->forget('_flash.new');

        return back();
    }
}
