import type { User } from './auth';
import type { Category } from './category';
import type { Review } from './review';

export interface Product {
  id: number;
  user_id: number;
  category_id: number;
  name: string;
  slug: string;
  description: string;
  price: number;
  stock: number;
  thumbnail_url: string;
  is_active: boolean;
  user?: User;
  category?: Category;
  formatted_price?: string;
  reviews?: Review[];
  reviews_avg_rating?: number;
  reviews_count?: number;
  rating?: number;
}
