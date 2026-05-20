export interface ImgSubasta {
    id?: number;
    subasta_id: number;
    url: string; // Tu link completo de Google
    created_at?: string;
    updated_at?: string;
}

export interface Subasta {
    id: number;
    marca_vehiculo: string;
    modelo_vehiculo: string;
    anio_vehiculo: string | number;
    nombre_refaccion: string;
    descripcion_problema: string;
    slug: string;
    urgencia: string;
    estado: string;
    fecha_expiracion: string;
    ofertas_count?: number;
    img_subastas?: ImgSubasta[];
}
