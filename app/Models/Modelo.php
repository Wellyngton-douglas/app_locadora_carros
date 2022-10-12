<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marca;

class Modelo extends Model
{
    use HasFactory;
    protected $fillable = ['marca_id', 'nome', 'imagem', 'numero_portas', 'lugares', 'air_bag', 'abs'];

    public function rules() {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|unique:modelos,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png,jpeg,jpg',
            'numero_portas' => 'required|integer|digits_between:1,4',
            'lugares' => 'required|integer|digits_between:1,8',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean' //true, false, 1, 0, "1", "0"
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique' => 'O nome da marca já existe',
            'min' => 'O nome deve ter no mínimo 3 caracteres',
            'mimes' => 'O arquivo deve ser uma imagem do tipo PNG/JPEG/JPG',
            'numero_portas.digits_between' => 'O numero de portas tem que ter entre 1 a 4 portas',
            'lugares.digits_between' => 'O numero de lugares tem que ser entre 1 a 8 lugares',
            'boolean' => 'O :attribute tem que ser verdadeiro, falso, 1 ou 2'
        ];
    }

    public function marca() {
        //um modelo pertence a uma marca
        return $this->belongsTo(Marca::class);
    }
}
