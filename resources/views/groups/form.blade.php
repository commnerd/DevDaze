{!! Form::text('title', 'Title', $group ? $group->title : "") !!}
{!! Form::text('url', 'URL', $group ? $group->url : "") !!}
{!! Form::text('fs_path', 'File System Path', $group ? $group->fs_path : "") !!}
{!! Form::submit("Submit") !!}