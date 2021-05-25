import { Image } from "@interfaces/image.interface";

export interface Volume {
  id?: number
  host_path: string
  container_path: string
  images?: Image
  created_at?: Date
  updated_at?: Date
}
