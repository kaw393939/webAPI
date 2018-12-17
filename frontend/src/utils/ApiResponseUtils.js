import distanceInWordsToNow from "date-fns/distance_in_words_to_now";
import get from "lodash/get";

export function withFormattedDate(item, path) {
    const createdAt = path ? get(item, path, "") : item.createdAt;

    const createdAtFormatted = `${distanceInWordsToNow(createdAt)} ago`;

    return {
        ...item,
        createdAtFormatted
    };
}

export function withQuestionAnswerCount(item, path) {
    const answers = path ? get(item, path, []) : item.answers;
    const answerCount = answers.length;

    return {
        ...item,
        answerCount
    };
}
