<link rel="stylesheet" href="{{ asset ('css/shared/codelab_ui/table1.css') }}"> 
<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Agregar</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="tabla table-hover text-center">
                <thead class="thead-primary">
                    <tr>
                        @foreach ($columns as $column)
                            <th>{{ $column }}</th>
                        @endforeach
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody >
                    @foreach ($items as $item)
                        <tr >
                            @foreach ($columns as $column)
                                <td class="p-0">
                                    {{-- Verificar si es una URL válida para mostrar una imagen --}}
                                    @if (filter_var($item->$column, FILTER_VALIDATE_URL) || file_exists(public_path($item->$column)))
                                        <img src="{{ $item->$column }}" alt="{{ $item->$column }}" class="img-thumbnail rounded-circle imagen" width="60">
                                    @elseif(filter_var($item->$column, FILTER_VALIDATE_URL) && preg_match('/\.(jpeg|jpg|png|gif)$/i', $item->$column))
                                        <img src="{{ $item->$column }}" alt="{{ $item->$column }}" class="img-thumbnail rounded-circle imagen" width="60">
                                    @elseif (file_exists(public_path('storage/' . $item->$column )))
                                        <img src="{{ asset('storage/' . $item->$column ) }}" alt="{{ $item->$column }}" class="img-thumbnail rounded-circle imagen" width="60">
                                    @else
                                        {{ $item->$column }} 
                                    @endif
                                </td>
                            @endforeach
                            <td class="p-0">
                                <button  class="btn btn-success btn-sm edit-button" onclick="emit('{{ json_encode($item) }}')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button> 
                              
                                {{-- <button   data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-success btn-sm">  
                                    <i class="fas fa-pencil-alt"></i>
                                </button>  --}}
                                <form action="{{route('admin.' . $modelName . '.destroy',$item)}}" method="post" style="display: inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



















































{{--  envia evento personalizado con un valor de item específico. Otros componentes o partes de tu aplicación 
    pueden escuchar este evento y realizar acciones en respuesta a él.  --}}
<script>
    function emit(item) {
        const event = new CustomEvent('selectedItem', { detail: item });
        document.dispatchEvent(event);
    }
</script> 



