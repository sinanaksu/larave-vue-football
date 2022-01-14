import axios from "axios";

export const getMatch = () => {
    return axios.get("api/matches/");
};

export const generateFixture = () => {
    return axios.get("api/matches/generate/");
};
