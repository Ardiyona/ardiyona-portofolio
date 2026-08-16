import { z } from 'zod';

export const landingPageSchema = z
    .object({
        ip_address: z
        .string()
    })

export type LandingPageFormSchema = z.infer<typeof landingPageSchema>;