@foreach($docker_images ?? '' as $docker_image)
    <div class="row">
        <div class="col-6">
            <a href="{{ route('apps.docker_images.edit', compact('app', 'docker_image')) }}">{{ $docker_image->label }}</a>
        </div>
        <div class="col-6">{{ $docker_image->tag }}</div>
        <div class="col-1">
            {!! Form::open()->formInLine()->route('apps.docker_images.destroy', compact('app', 'docker_image'))->delete() !!}
                <input type="submit" value="Delete" />
            {!! Form::close() !!}
        </div>
    </div>
@endforeach
<div class="row">
    <div class="col-12">
        <a href="{{ route('apps.docker_images.create', compact('app')) }}" class="btn btn-primary">Add Docker Image</a>
    </div>
</div>
