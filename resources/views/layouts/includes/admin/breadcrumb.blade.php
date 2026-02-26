{{-- Verificar si hay un elemento en el arreglo breadcrumbs --}}
@if (count($breadcrumbs))
{{--Display_block--}}
    <nav class="mb-2 block">
        <ol class="flex flex-wrap text-slate-600 text-sm">
            @foreach ($breadcrumbs as $item)
            <li class="flex items-center">
                {{--Si NO es el primer elemento, pintar por separado con un espacio--}}
                @unless ($loop -> first)
                {{--El span crea el separador con margen lateral--}}
            <span class="px-2 text-gray-400">
                    /
            </span>

                @endunless
                {{--Revisa si existe una llave/propiedad llamada 'HREF'--}}
                @isset($item['href'])
                {{--Si existe, se muestra como enlace con ocapacidad reducida--}}
                    <a href="{{ $item['href'] }}" class="opacity-60 hover:opacity-100 transition">
                        {{$item['name']}}
                    </a>
                @else
                    {{$item['name']}}
                    </span>
                @endisset
            </li>
            @endforeach
        </ol>
     {{-- El ultimo elemento aparezca resaltado--}}
        @if(count($breadcrumbs) > 1)
            <h6 class="font-bold mt-2">
                {{end($breadcrumbs)['name']}}
            </h6>
        @endif
    </nav>
@endif