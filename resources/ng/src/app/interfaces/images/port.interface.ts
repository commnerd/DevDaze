import { Image } from "@interfaces/image.interface";

export interface Port {
  id?: number
  host_port: number
  container_port: number
  image?: Image
  created_at?: Date
  updated_at?: Date
}
