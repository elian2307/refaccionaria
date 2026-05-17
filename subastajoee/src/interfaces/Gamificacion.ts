export interface Logro {
    nombre: string;
    descripcion: string;
    desbloqueado: boolean;
}

export interface GamificacionData {
    puntos: number;
    nivel: number;
    nombre_nivel: string;
    insignia: string;
    beneficio: string;
    puntos_siguiente_nivel: number | null;
    puntos_restantes: number;
    progreso: number;
    logros: Logro[];
}
