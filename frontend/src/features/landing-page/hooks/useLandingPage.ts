import { useQuery } from "@tanstack/react-query";
import { landingPageApi } from "../api/landingPage.api";

export const useLandingPageProjects = () => {
    return useQuery({
        queryKey: ['projects'],
        queryFn: () => landingPageApi.getAllProjects(),
        staleTime: 10 * 60 * 1000,
        enabled: true,
    });
};

export const useLandingPageTechStacks = () => {
    return useQuery({
        queryKey: ['tech-stacks'],
        queryFn: () => landingPageApi.getAllTechStacks(),
        staleTime: 10 * 60 * 1000,
        enabled: true,
    });
};

export const useLandingPageExperiences = () => {
    return useQuery({
        queryKey: ['experiences'],
        queryFn: () => landingPageApi.getAllExperiences(),
        staleTime: 10 * 60 * 1000,
        enabled: true,
    });
};