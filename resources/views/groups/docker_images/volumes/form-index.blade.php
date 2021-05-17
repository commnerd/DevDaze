@foreach($volumes ?? '' as $volume)
    <div class="row">
        <div class="col-6">
            <a href="{{ route('groups.docker_images.edit', compact(, 'docker_image', 'volume')) }}">{{ $volume->label }}</a>
        </div>
        <div class="col-6">{{ $volume->internal_path }}</div>
    </div>
@endforeach
<div class="row">
    <div class="col-12">
        <a href="{{ route('groups.docker_images.create', compact()) }}" class="btn btn-primary">Add Volume</a>
    </div>
</div>
