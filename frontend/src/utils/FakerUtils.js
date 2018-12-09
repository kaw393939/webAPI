import faker from "faker";
import range from "lodash/range";

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
        }, 500);
    });
}
