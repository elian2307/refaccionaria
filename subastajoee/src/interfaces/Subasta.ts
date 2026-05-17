export interface Subasta {
    id: number;
    marca_vehiculo: string;
    modelo_vehiculo: string;
    anio_vehiculo: string | number;
    nombre_refaccion: string;
    descripcion_problema: string;
    urgencia: string;
    estado: string;
    fecha_expiracion: string;
    ofertas_count?: number;
}
