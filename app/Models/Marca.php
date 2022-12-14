<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Modelo;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules() {
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png'
        ];
        /* unique: parametros
            1) tabela
            2) nome da coluna que será pesquisada na tabela
            3) id do registro que será desconsiderado na pesquisa
        */
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique' => 'O nome da marca já existe',
            'min' => 'O nome deve ter no mínimo 3 caracteres',
            'mimes' => 'O arquivo deve ser uma imagem do tipo PNG'
        ];
    }

    public function modelos() {
        //uma marca pertence a varios modelos
        return $this->hasMany(Modelo::class);
    }
}
