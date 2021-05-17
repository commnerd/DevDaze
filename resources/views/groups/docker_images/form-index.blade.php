@foreach($docker_images ?? '' as $docker_image)
    <div class="row">
        <div class="col-6">
            <a href="{{ route('groups.docker_images.edit', compact('group', 'docker_image')) }}">{{ $docker_image->label }}</a>
        </div>
        <div class="col-6">{{ $docker_image->tag }}</div>
        <div class="col-1">
            {!! Form::open()->formInLine()->route('groups.docker_images.destroy', compact('group', 'docker_image'))->delete() !!}
                <input type="submit" value="Delete" />
            {!! Form::close() !!}
        </div>
    </div>
@endforeach
<div class="row">
    <div class="col-12">
        <a href="{{ route('groups.docker_images.create', compact('group')) }}" class="btn btn-primary">Add Docker Image</a>
    </div>
</div>
