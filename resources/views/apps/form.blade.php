{!! Form::text('title', 'Title', $app ? $app->title : "") !!}
{!! Form::text('url', 'URL', $app ? $app->url : "") !!}
{!! Form::text('fs_path', 'File System Path', $app ? $app->fs_path : "") !!}
{!! Form::submit("Submit") !!}