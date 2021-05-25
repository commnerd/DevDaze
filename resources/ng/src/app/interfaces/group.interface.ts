import { Image } from "./image.interface";

export interface Group {
  id?: number
  title: string
  fs_path: string
  url: string
  slug?: string
  images?: Image[]
  created_at?: Date
  updated_at?: Date
}
