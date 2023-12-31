@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-success">
            Torna alla lista
        </a>

        <h1>Modifica Project</h1>

        <form action="{{ route('admin.projects.update', $projects) }}" method="POST" enctype="multipart/form-data">>
            @csrf {{-- Aggiunge il token CSRF --}}
            @method('PUT') {{-- Utilizza il metodo PUT per l'aggiornamento --}}

            <div class="row">
                <div class="col-3">
                    <label for="title">Titolo</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $projects->title) }}"
                        class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <label class="tiping my-3" for="type">Tipologia</label>
                    <select class="form-select " id="type" name="type_id">
                        <option value=""></option>
                        @foreach ($types as $type)
                            <option @selected($type->id == old('type_id', $projects->type?->id)) value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>

                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Tehnologies</label>
                            <div class="form-check @error('technologies') is-valid @enderror p-0">
                                @foreach ($technologies as $technology)
                                    <input type="checkbox" id="technology-{{ $technology->id }}"
                                        value="{{ $technology->id }}" name="technologies[]" class="form-check-control"
                                        @if (in_array($technology->id, old('technology', $project_technologies ?? []))) checked @endif>
                                    {{-- $project_technologies quidi questa variabile rappresenta il legame tra i modelli Project e Technology --}}
                                    {{-- Il null operator chiede se c e questa relazione $project_technologies,altrimenti usa un array vuoto  --}}
                                    <label for="technology-{{ $technology->id }}">
                                        {{ $technology->name_technologies }}
                                    </label>
                                    <br>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <label for="content">Content</label>
                        <input type="content" id="content" name="content" value="{{ old('content', $projects->title) }}"
                            class="form-control @error('title') is-invalid @enderror">
                        </select>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <textarea class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" rows="4">{{ old('slug') }}</textarea>
                        @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- IMAGE -->
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-8">
                                <label for="cover_image" class="form-label">Carica immagine</label>
                                <input type="file" class="form-control" id="cover_image" name="cover_image"
                                    value="{{ old('cover_image') }}">
                                @error('cover_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-4 position-relative">
                                @if ($projects->cover_image)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger delete-image-button">
                                        <i class="fas fa-trash" id="delete-image-button"></i>
                                        {{-- 1.dai un id al icon trash per identifacarla --}}
                                        <span class="visually-hidden">delete image</span>
                                    </span>
                                @endif
                                <img src="{{ asset('/storage/' . $projects->cover_image) }}" class="img-fluid"
                                    alt="" id="cover_image_preview">
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Salva</button>
        </form>
        @if ($projects->cover_image)
            <form id="delete-image-form" action="{{ route('admin.projects.delete-image', $projects) }}" method="POST">
                {{-- 4.action -> il form porta a una route nel web.php --}}
                @method('DELETE')
                @csrf
            </form>
        @endif

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        const inputFileElement = document.getElementById('cover_image');
        const coverImagePreview = document.getElementById('cover_image_preview');
        inputFileElement.addEventListener('change', function() { //prendo l'input,intercetto il change
            alert('Immagine Cambiata');
            const [file] = this.files //prendo il file dentro input
            //quando l'immagine viene cambiata crea un Array di files da dove andiamo a estrarrne un solo file 

            //console.log(URL.createObjectURL(file)); //genera un blob-un formato di dati che contiene una lunga stringa di dati(che sono proprio l'immagine fisica)
            coverImagePreview.src = URL.createObjectURL(
                file); //il source di coverImagePreview e uguale al URL che creo dal file 
        })
    </script>
    {{-- SCRIPT PER  LA CANCELLAZIONE IMMAGINE  --}}
    @if ($projects->cover_image)
        <script>
            const deleteImageButton = document.getElementById('delete-image-button'); // 2.prendi l/ id del icon 
            const deleteImageForm = document.getElementById('delete-image-form'); // 3.prendi l/id del form 
            deleteImageButton.addEventListener('click', function() { // 3.all click si invia il form
                (deleteImageForm.submit());
            })
        </script>
    @endif
@endsection
