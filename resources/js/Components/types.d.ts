export interface Column {
    field: string;
    label: string;
    render?: () => void;
}
