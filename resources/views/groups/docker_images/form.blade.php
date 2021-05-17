{!! Form::hidden('group_id', $group ? $group->id : "") !!}
{!! Form::text('label', 'Image Label', $docker_image ?? '' ? $docker_image->label : "") !!}
{!!
    Form::text('tag', 'Image Tag', $docker_image ?? '' ? $docker_image->tag : "")
        ->info("Ex. some.domain.com/user/image:latest, user/image, nginx")
!!}
{!! Form::submit("Submit") !!}
