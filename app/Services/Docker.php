<?php

namespace App\Services;

use Symfony\Component\Process\Process;
use App\Models\DockerImage;

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
        $cmd = ["docker", "ps", "--filter", "name=".$dockerImage->name()];

        $output = self::execute($cmd, $dockerImage->group->fs_path);

        return $output[self::STATUS_LABEL] === self::STATUS_SUCCESS && preg_match("/".$dockerImage->name()."/", $output[self::TYPE_OUT]);
    }

    /**
     * Run a container from a docker image
     *
     * @param DockerImage $dockerImage
     * @return array
     */
    public static function run(DockerImage $dockerImage): array
    {
        $cmd = ["docker", "run", "-d", "--rm", "--name", $dockerImage->name(), $dockerImage->tag];

        return self::execute($cmd, $dockerImage->group->fs_path);
    }

    /**
     * Kill a docker image
     *
     * @param DockerImage $dockerImage
     * @return array
     */
    public static function kill(DockerImage $dockerImage): array
    {
        $cmd = ["docker", "kill", $dockerImage->name()];

        return self::execute($cmd, $dockerImage->group->fs_path);
    }

    /**
     * Restart a service
     *
     * @param DockerImage $dockerImage
     * @return array
     */
    public static function restart(DockerImage $dockerImage): array
    {
        if(self::running($dockerImage)) {
            self::kill($dockerImage);
        }

        return self::run($dockerImage);
    }

    /**
     * Restart a service
     *
     * @param Group $group
     * @return boolean
     */
    public static function networkDefined(Group $group): boolean
    {
        $cmd = ["docker", "network", "ls", "|", "grep", $group->slug];

        dd(self::execute($cmd));
    }

    public static function update_network(Group $group): array
    {
        if(self::execute(sprintf('docker network ls --filter "name=%s" --format "{{.Name}}"', $group->slug)[self::TYPE_OUT] !== $group->slug)) {

        }
    }

    public static function add_network(Group $group): array
    {
        if(self::execute(sprintf('docker network ls --filter "name=%s" --format "{{.Name}}"', $group->slug)[self::TYPE_OUT] !== $group->slug)) {

        }
    }

    public static function remove_network(Group $group): array
    {
        if(self::execute(sprintf('docker network ls --filter "name=%s" --format "{{.Name}}"', $group->slug)[self::TYPE_OUT] !== $group->slug)) {

        }
    }

    private static function execute(array $command, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60) {
        $process = new Process($command, $cwd, $env, $input, $timeout);

        $process->run();

        if($process->isSuccessful()) {
            return [self::STATUS_LABEL => self::STATUS_SUCCESS, self::TYPE_OUT => $process->getOutput()];
        }

        return [self::STATUS_LABEL => self::STATUS_FAIL, self::TYPE_ERR => $process->getErrorOutput()];
    }
}
