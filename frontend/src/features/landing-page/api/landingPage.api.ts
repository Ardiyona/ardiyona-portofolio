import axiosInstance from "../../../lib/axios";

export const landingPageApi = {
    getAllProjects: async () =>
        (await axiosInstance.get('/project')).data,

    getAllTechStacks: async () =>
        (await axiosInstance.get('/tech-stack')).data,

    getAllExperiences: async () =>
        (await axiosInstance.get('/experience')).data,

    createViewLog: async () => {
        const response = await axiosInstance.post('/views/log');
        console.log(response);
        return response.data;
    }
};