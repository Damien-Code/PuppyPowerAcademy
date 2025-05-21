import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface FooterItem {
    title: string;
    href: string;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    role_id: number;
}

export interface OrderProducts {
    order: Order;
    product: Product;
    amount: number;
}

export interface Order {
    id: number;
    user_id: number;
    postal_code: string;
    country: string;
    city: string;
    street: string;
    house_number: string;
    created_at: string;
    updated_at: string;
    deleted_at: string;
    totalPrice: number;
    order_products: OrderProducts[];
}

export interface Training {
    id: number;
    title: string;
    price: number;
    description: string;
    link: string;
    created_at: string;
    updated_at: string;
}

export interface Product {
    id: number;
    name: string;
    description: string;
    price: number;
    stock: number;
    mediaFile?: MediaFile;
    created_at: string;
    updated_at: string;
    deleted_at: string;
}


export interface Message {
    id: number;
    first_name: string;
    last_name: string;
    email: string;
    message: string;
    is_completed: boolean;
    created_at: string;
}

export interface MediaFile {
    id: number,
    model_type: string,
    model_id: number,
    uuid: string,
    collection_name: string,
    name: string,
    file_name: string,
    mime_type: string,
    disk: string,
    conversions_disk: string,
    size: number,
    manipulations: string[],
    custom_properties: string[],
    generated_conversions: string[],
    responsive_images: string[],
    order_column: number,
    created_at: string,
    updated_at: string,
    original_url: string,
    preview_url: string,
}

export type BreadcrumbItemType = BreadcrumbItem;
