<?php

namespace App\Livewire\Shared;

use App\Models\Category;
use App\Models\Ingredient;
use Livewire\Component;
use App\Models\Recipe;
use App\Models\Multimedia;
use App\Models\PreparationStep;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class FormRecipe extends Component
{
    use WithFileUploads; 
    //vars modal
    public  $titleModal = "Crear Receta", $btnModal = "Crear" , $openModal =false;
    //variables inputs
    public $name,$difficulty,$preparation_time,$description,$category_id,$identificador,$recipeId,
    $ingredientes = [],$pasos=[], $images = [] ;

    private $resetVariables = ['openModal','category_id','name','preparation_time','difficulty','description','ingredientes','pasos','btnModal','titleModal'];
    //emit    
    protected $listeners = ['editarRecetaForm'];
    public $rules = [
        'name'=> 'required',
        'difficulty'=>'required',
        'preparation_time' => 'required',
        'description'=> 'required',
        'category_id' => 'required',
    ];

    public function mount(){ 
        $this->identificador = rand(); //le asigna un numero al azar o random
    }
    public function render(){
        $categories = Category::all();
        return view('livewire.shared.form-recipe',compact('categories'));
    }
    public function createOrUpdate(){    
        $recipe = [
            'name' => $this->name,
            'difficulty' =>$this->difficulty,
            'description'=>$this->description,
            'preparation_time' => $this->preparation_time,
            'category_id' =>$this->category_id,
            'user_id'=>Auth::user()->id,
        ];
        if ($this->btnModal == "Crear") {
            $this->validate();
            $recipe = Recipe::create($recipe);
             foreach ($this->images as $image) {
                //     $path = $image->store('recipes');
                
                //     $multimedia = new Multimedia();
                //     $multimedia->ruta = $path;
                //     $multimedia->tipo = 'imagen';
                  //   $recipe->multimedia()->save($multimedia);
             }
            // Iterar sobre los ingredientes y crear cada uno
            foreach ($this->ingredientes as $ingrediente) {
                 Ingredient::create([
                     'recipe_id' => $recipe->id,
                     'quantity' => $ingrediente['quantity'],
                     'unit' => $ingrediente['unit'],
                     'name' => $ingrediente['name'],
                     'measurement' => $ingrediente['measurement']
                 ]);
             }
               // Crear los pasos de preparación
               
            foreach ($this->pasos as $index => $paso) {
                PreparationStep::create([
                    'recipe_id' => $recipe->id,
                     'step_number' => $index + 1,
                     'description_step' => $paso
                 ]);
            }
            
             $this->reset($this->resetVariables);
            // $this->identificador = rand();
        } elseif ($this->btnModal == "Actualizar") {
            $recipeEdit = Recipe::find($this->recipeId);
            
            if ($recipeEdit) {
                $recipe['user_id'] = $recipeEdit->user_id;
                $recipeEdit->update($recipe);
                $recipeEdit->multimedia()->delete(); // Eliminar todas las imágenes existentes
                foreach ($this->images as $image) {
                    $path = $image->store('recipes');
                    $multimedia = new Multimedia();
                    $multimedia->ruta = $path;
                    $multimedia->tipo = 'imagen';
                    $recipeEdit->multimedia()->save($multimedia);
                }
                
                $this->reset($this->resetVariables);
                $this->identificador = rand();
            }
        }
    }

    public function editarRecetaForm(Recipe $recipe){
        $this->recipeId = $recipe->id;
        $this->name =$recipe->name;
        $this->description =$recipe->description;
        $this->difficulty =$recipe->difficulty;
        $this->preparation_time =$recipe->preparation_time;
        $this->ingredientes = $recipe->ingredients;
        $this->pasos = $recipe->preparationSteps;
        $this->category_id = $recipe->category_id;
        $this->titleModal = "Editar Receta";
        $this->btnModal = "Actualizar";
         $this->openModal= true;
    }


    public function agregarIngrediente()
    {
        $this->ingredientes[] = ['quantity' => '', 'unit' =>'','name' => '', 'measurement' => '',];
    }

    public function eliminarIngrediente($index)
    {
        unset($this->ingredientes[$index]);
        $this->ingredientes = array_values($this->ingredientes);
    }

    public function agregarPaso(){ $this->pasos[] = '';}

    public function eliminarPaso($index){
        unset($this->pasos[$index]);
        $this->pasos = array_values($this->pasos);
    }

    public function updatedImages()
    {
        // Aquí puedes realizar acciones adicionales al actualizar las imágenes, si es necesario
    }

    public function removeImage($index){
        unset($this->images[$index]);
    }
}
