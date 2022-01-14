import axios from "axios";

export const getTeams = () => {
    return axios.get("api/teams/");
};

export const generateTournament = () => {
    return axios.get("api/teams/generate/");
};
