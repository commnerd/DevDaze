<?php

namespace App\Services;

class Docker
{
    public const TYPE_ERR = "error";
    public const TYPE_OUT = "output";

    public const STATUS_LABEL = "status";
    public const STATUS_FAIL = "failed";
    public const STATUS_SUCCESS = "success";

    /**
     * Check if a docker image is running
     *
     * @param DockerImage $dockerImage
     * @return bool
     */
    public static function running(DockerImage $dockerImage): bool
    {
        $cmd = ["docker", "ps", "--filter", "name=".$dockerImage->name];

        $output = self::execute($cmd, $dockerImage->app->fs_path);

        return $output[self::STATUS_LABEL] === self::STATUS_SUCCESS && sizeof($output[self::TYPE_OUT]) > 0;
    }

    /**
     * Run a container from a docker image
     *
     * @param DockerImage $dockerImage
     * @return array
     */
    public static function run(DockerImage $dockerImage): array
    {
        $cmd = ["docker", "run", "-d", "--rm", "--name", $dockerImage->name, $dockerImage->tag];

        if(!self::running($dockerImage)) {
            return self::execute($cmd, $dockerImage->app->fs_path);
        }
    }

    /**
     * Kill a docker image
     *
     * @param DockerImage $dockerImage
     * @return array
     */
    public static function kill(DockerImage $dockerImage): array
    {
        $cmd = ["docker", "kill", $dockerImage->name];

        return self::execute($cmd, $dockerImage->app->fs_path);
    }

    /**
     * Restart a service
     *
     * @param DockerImage $dockerImage
     * @return array
     */
    public static function restart(DockerImage $dockerImage): array
    {
        if(!self::running($dockerImage)) {
            return self::start($dockerImage);
        }

        $cmd = ["docker", "restart", $dockerImage->name];

        self::execute($cmd);
    }

    private static function execute(array $command, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60) {
        $process = new Process($command, $cwd, env, $input, $timeout);

        $process->run();

        if($process->isSuccessful()) {
            return [self::STATUS_LABEL => self::STATUS_SUCCESS, self::TYPE_OUT => $process->getOutput()];
        }

        return [self::STATUS_LABEL => self::STATUS_FAIL, self::TYPE_ERR => $process->getErrorOutput()];
    }
}
