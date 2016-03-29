<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Translation;
use App\Word;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo('translation index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'body' => 'required|unique:translations,body',
                'word_id' => 'sometimes|exists:words,id',
            ]
        );

        if ($validator->passes()) {
            if ($wordId = $request->get('word_id')) {
                $word = Word::find($wordId);

                if (is_null($word->position)) {
                    $translation = Translation::create(['body' => $request->get('body')]);

                    $translation->words()->attach($word);

                    $response = response()->json(['id' => $translation->id], 201);
                } else {
                    $response = response()->json(['errors' => ['You have attempted to bind a translation with a non-custom word']], 400);
                }
            } else {
                $translation = Translation::create(['body' => $request->get('body')]);

                $response = response()->json(['id' => $translation->id], 201);
            }
        } else {
            $response = response()->json(['errors' => $validator->messages()->all()], 400);
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo('translation show');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo('translation update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo('translation destroy');
    }
}
