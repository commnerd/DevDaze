import { Image } from "@interfaces/image.interface";

export interface Env {
  id?: number
  label: string,
  value: string,
  image?: Image
  created_at?: Date
  updated_at?: Date
}
