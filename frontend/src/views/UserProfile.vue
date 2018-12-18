<template>
  <v-container fluid>
    <v-layout>
      <v-flex xs12 sm12 md6 lg6 class="infoCardWrapper">
        <v-card dark color="blue darken-2" class="infoCard">
          <v-layout column class="infoCardContent">
            <v-flex class="infoCardRow">
              <v-avatar size="68">
                <img :src="profileAvatar" alt="avatar">
              </v-avatar>
            </v-flex>
            <v-flex class="infoCardRow">
              <p class="headline font-weight-bold infoCardUserName">{{ name }}</p>
            </v-flex>
            <v-flex class="infoCardRow" v-if="isLoggedIn">
              <v-btn class="white--text" :to="editProfileLink">EDIT PROFILE</v-btn>
            </v-flex>
          </v-layout>
        </v-card>
      </v-flex>
      <v-flex xs12 sm12 md6 lg6 class="infoCardWrapper">
        <v-card dark color="blue darken-2" class="infoCard">
          <v-layout column class="infoCardContent">
            <v-flex>
              <v-icon small color="black darken-2">email</v-icon>
              <span class="body-2 infoCardUserEmail">{{ email }}</span>
            </v-flex>
            <v-flex>
              <p class="subheading">{{ description }}</p>
            </v-flex>
          </v-layout>
        </v-card>
      </v-flex>
    </v-layout>
    <v-layout justify-center wrap>
      <template v-for="question in questions">
        <card :key="question.id">
          <card-header>
            <v-flex xs6 class="cardHeader__left">
              <span class="font-weight-regular font-italic">{{ question.createdAtFormatted }}</span>
            </v-flex>
            <v-flex xs6 class="cardHeader__right">
              <v-btn icon color="blue-grey--text darken-1--text">
                <v-icon>more_vert</v-icon>
              </v-btn>
            </v-flex>
          </card-header>

          <v-card-text>
            <p class="title">{{ question.text }}</p>
          </v-card-text>

          <v-layout class="stats">
            <v-flex shrink class="statItem">
              <div>
                <v-icon>favorite</v-icon>
              </div>
              <div>
                <span>{{ question.likes }}</span>
              </div>
            </v-flex>
            <v-flex shrink class="statItem">
              <div>
                <v-icon>mode_comment</v-icon>
              </div>
              <div>
                <span>{{ question.comments }}</span>
              </div>
            </v-flex>
          </v-layout>

          <card-footer>
            <template v-for="tag in question.tags">
              <v-chip label outline small color="white" :key="tag.id">{{ tag.title }}</v-chip>
            </template>
          </card-footer>
        </card>
      </template>
    </v-layout>
  </v-container>
</template>

<style scoped>
.infoCard {
  padding: 15px 10px;
  height: 225px;
}
.infoCardWrapper {
  margin: 5px 10px;
}
.infoCardRow {
  margin: 5px 0;
  display: flex;
  justify-content: center;
}
.infoCardContent {
  height: 100%;
  padding: 0 15px;
}
.infoCardUserName {
  margin: 0;
  text-transform: uppercase;
}
.infoCardUserEmail {
  display: inline-block;
  margin-left: 10px;
}

.cardHeader__right {
  text-align: right;
}
.cardHeader__left {
  margin-left: 20px;
}

.stats {
  display: flex;
  justify-content: flex-end;
  padding-left: 15px;
  padding-bottom: 10px;
}
.statItem {
  display: flex;
  align-items: center;
  margin-right: 15px;
}
.statItem div {
  margin-right: 5px;
}
</style>

<script>
import faker from "faker";
import { mapGetters } from "vuex";
import Card from "@/components/Card.vue";
import CardHeader from "@/components/CardHeader.vue";
import CardFooter from "@/components/CardFooter.vue";
import { fetchQuestions } from "@/utils/FakerUtils";
import { withFormattedDate } from "@/utils/ApiResponseUtils";

export default {
  components: {
    Card,
    CardHeader,
    CardFooter
  },

  created() {
    fetchQuestions()
      .then(response => {
        this.questions = response.map(withFormattedDate);
      })
      .catch(console.error);
  },

  data() {
    return {
      questions: [],
      name: "John Doe",
      email: "johndoe@abc.xyz",
      description:
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In facilisis at tortor at maximus. Quisque dignissim ipsum neque, a aliquam diam consequat in. Fusce lacinia dictum risus, nec pulvinar erat sodales.",
      profileAvatar: faker.image.avatar()
    };
  },

  methods: {
    edit() {
      //    attempt to take the user to edit-profile route after checking for token in the storage
      //    if the user is authorized, user is guided to edit-profile page with its information pre-populated
      //    otherwise 401 error thrown out
    }
  },

  computed: {
    ...mapGetters(["isLoggedIn"]),

    showEditProfileButton() {
      // TODO: return true or false based on whether
      // user is allowed to edit this profile or not
    },

    editProfileLink() {
      // TODO: get userId from store when ready
      // const userId = this.authUser.id
      const userId = 1;

      return `/profile/${userId}/edit`;
    }
  }
};
</script>