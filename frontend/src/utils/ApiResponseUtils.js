import distanceInWordsToNow from "date-fns/distance_in_words_to_now";

export function withFormattedDate(item) {
    const createdAtFormatted = `${distanceInWordsToNow(item.createdAt)} ago`;

    return {
        ...item,
        createdAtFormatted
    };
}
