<?php

namespace OldExtended\Http\Controllers;

use Illuminate\Http\Request;

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
    public function update(Request $form)
    {
        // Não faz nada e volta para o formulário.
        // Operação apenas para testar os 'olds'
        return back();
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
