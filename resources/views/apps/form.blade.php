{!! Form::text('title', 'Title', $app ? $app->title : "") !!}
{!! Form::text('url', 'URL', $app ? $app->url : "") !!}
{!! Form::text('fs_path', 'File System Path', $app ? $app->fs_path : "") !!}

@if(!empty($app->docker_images))
<div class="row">
    <div class="col-12 well">
        @include('apps.docker_images.form-index', ['docker_images' => $app->docker_images])
    </div>
</div>
@endif

{!! Form::submit("Submit") !!}