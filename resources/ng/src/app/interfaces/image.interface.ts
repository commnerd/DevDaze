import { Volume } from "@interfaces/images/volume.interface";
import { Port } from "@interfaces/images/port.interface";
import { Env } from "@interfaces/images/env.interface";
import { Group } from "@interfaces/group.interface";

export interface Image {
  id?: number
  name: string
  slug?: string
  group: Group
  envs: Env[]
  ports: Port[]
  volumes: Volume[]
  created_at?: Date
  updated_at?: Date
}
