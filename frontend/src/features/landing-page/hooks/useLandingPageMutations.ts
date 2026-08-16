import { useMutation, useQueryClient } from '@tanstack/react-query';
import { landingPageApi } from '../api/landingPage.api';

export const useCreateViewLog = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: () => landingPageApi.createViewLog(),
        onSuccess: () => {
            queryClient.invalidateQueries({ queryKey: ['view_log']})
        }
    });
}