<?php

namespace App\Models;
use CodeIgniter\Model;

class Averia extends Model{
  protected $table = 'averias';
  protected $primaryKey = 'id';
  protected $allowedFields = ['cliente', 'problema', 'fechahora'];

}