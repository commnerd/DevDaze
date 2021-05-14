@foreach($volumes ?? '' as $volume)
    <div class="row">
        <div class="col-6">
            <a href="{{ route('apps.docker_images.edit', compact('app', 'docker_image', 'volume')) }}">{{ $volume->label }}</a>
        </div>
        <div class="col-6">{{ $volume->internal_path }}</div>
    </div>
@endforeach
<div class="row">
    <div class="col-12">
        <a href="{{ route('apps.docker_images.create', compact('app')) }}" class="btn btn-primary">Add Volume</a>
    </div>
</div>
