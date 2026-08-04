import type { Category } from './category';
import type { Review } from './review';

export interface Product {
  id: number;
  user_id: number;
  category_id: number;
  name: string;
  slug: string;
  description?: string;
  price: number;
  rating?: number;
  stock: number;
  thumbnail_url: string;
  is_active: boolean;
  category?: Category;
  reviews?: Review[];
  reviews_count?: number;
}
