import faker from "faker";
import range from "lodash/range";
import random from "lodash/random";

export function fetchQuestion(id) {
    return new Promise(resolve => {
        setTimeout(() => {
            resolve({
                id,
                author: {
                    firstName: faker.name.firstName(),
                    lastName: faker.name.lastName(),
                    avatar: faker.image.avatar()
                },
                text: faker.lorem.sentences(),
                tags: range(0, 5).map(id => ({
                    id,
                    title: faker.lorem.word()
                })),
                createdAt: faker.date.past(),
                likes: faker.random.number(),
                votes: faker.random.number(),
                answers: range(0, 10).map(id => ({
                    id,
                    author: {
                        firstName: faker.name.firstName(),
                        lastName: faker.name.lastName(),
                        avatar: faker.image.avatar()
                    },
                    text: faker.lorem.sentences(),
                    createdAt: faker.date.past()
                }))
            });
        }, 250);
    });
}

export function fetchQuestions() {
    return new Promise(resolve => {
        const questions = range(0, 10).map(id => ({
            id,
            text: faker.lorem.sentences(),
            tags: range(0, 5).map(tagId => ({
                id: tagId,
                title: faker.lorem.word()
            })),
            createdAt: faker.date.past(),
            likes: random(0, 10),
            comments: random(0, 10)
        }));

        resolve(questions);
    });
}
