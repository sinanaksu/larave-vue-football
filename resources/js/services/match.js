import axios from "axios";

export const getMatch = () => {
    return axios.get("api/matches/");
};

export const generateFixture = () => {
    return axios.get("api/matches/generate/");
};

export const playNextWeek = () => {
    return axios.get("api/matches/nextweek/");
};

export const playAllWeek = () => {
    return axios.get("api/matches/playallweek/");
};

export const updateScores = (params) => {
    return axios.put("api/match/", params);
};
