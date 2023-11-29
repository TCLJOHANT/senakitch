<div>
        <link rel="stylesheet" href="{{ asset ('css/menu.css') }}">
        <section class="menu" id="menu">
        <h1 class="heading " > nuestros <span>Platos</span> </h1> 
        @can('admin.recipes.store')
        <div class="flex m-6 mx-auto w-full">
          @livewire('shared.form-plate') 
        </div>
        @endcan
        <div class="container" >
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box-container">
                        @foreach($platos as $plato)
                         <livewire:app.components.card.card-plato :plato="$plato" :key="$plato->id" lazy/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>