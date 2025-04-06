@extends('installation.layout')

@section('content')
<div class="mb-4">
    <h3 class="welcome-heading">Requisitos del Sistema</h3>
    <p class="lead">Verificando que tu servidor cumpla con los requisitos necesarios para la instalación.</p>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Requisito</th>
                        <th>Estado Actual</th>
                        <th class="pe-4">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requirements as $requirement)
                        <tr>
                            <td class="ps-4 py-3 align-middle">
                                <div class="d-flex align-items-center">
                                    @if($requirement['name'] == 'PHP Version')
                                        <i class="fab fa-php text-primary me-3 fa-lg"></i>
                                    @elseif(str_contains($requirement['name'], 'Extension'))
                                        <i class="fas fa-puzzle-piece text-primary me-3"></i>
                                    @elseif(str_contains($requirement['name'], 'Permission'))
                                        <i class="fas fa-lock text-primary me-3"></i>
                                    @else
                                        <i class="fas fa-cog text-primary me-3"></i>
                                    @endif
                                    {{ $requirement['name'] }}
                                </div>
                            </td>
                            <td class="py-3 align-middle">
                                <code>{{ $requirement['current'] }}</code>
                            </td>
                            <td class="pe-4 py-3 align-middle">
                                @if($requirement['result'])
                                    <span class="badge bg-success rounded-pill d-flex align-items-center justify-content-center" style="width: 85px">
                                        <i class="fas fa-check-circle me-1"></i> Cumple
                                    </span>
                                @else
                                    <span class="badge bg-danger rounded-pill d-flex align-items-center justify-content-center" style="width: 85px">
                                        <i class="fas fa-times-circle me-1"></i> No Cumple
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(collect($requirements)->where('result', false)->isNotEmpty())
    <div class="alert alert-danger border-0 d-flex align-items-center shadow-sm" role="alert">
        <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
        <div>
            <strong>Error:</strong> Tu servidor no cumple con todos los requisitos necesarios. Por favor, corrige los problemas antes de continuar.
        </div>
    </div>
@else
    <div class="alert alert-success border-0 d-flex align-items-center shadow-sm" role="alert">
        <i class="fas fa-check-circle me-3 fa-lg"></i>
        <div>
            <strong>¡Felicidades!</strong> Tu servidor cumple con todos los requisitos necesarios.
        </div>
    </div>
@endif
@endsection

@section('footer')
    <a href="{{ route('installation.welcome') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i> Anterior
    </a>
    
    @if(collect($requirements)->where('result', false)->isEmpty())
        <a href="{{ route('installation.database') }}" class="btn btn-primary">
            Configurar Base de Datos <i class="fas fa-arrow-right ms-2"></i>
        </a>
    @else
        <button class="btn btn-primary opacity-50" disabled>
            Configurar Base de Datos <i class="fas fa-arrow-right ms-2"></i>
        </button>
    @endif
@endsection