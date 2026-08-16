export interface ViewLogFormData {
    ip_address?: string | null;
}

export interface ApiErrorResponse {
  success: false;
  message: string;
  error?: string;
  errors?: Record<string, string[]>;
}