<template>
  <v-container fluid>
    <template v-if="dataFetched">
      <v-layout>
        <v-flex xs12 sm12 md6 lg6 class="infoCardWrapper">
          <v-card dark color="blue darken-2" class="infoCard">
            <v-layout column class="infoCardContent">
              <v-flex class="infoCardRow">
                <v-avatar size="68">
                  <img :src="userInfo.profileAvatar" alt="avatar">
                </v-avatar>
              </v-flex>
              <v-flex class="infoCardRow">
                <p class="headline font-weight-bold infoCardUserName">{{ userInfo.fullName }}</p>
              </v-flex>
              <v-flex class="infoCardRow" v-if="showEditProfileButton">
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
                <span class="body-2 infoCardUserEmail">{{ userInfo.email }}</span>
              </v-flex>
              <v-flex>
                <p class="subheading">{{ userInfo.bio }}</p>
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
    </template>

    <v-layout>
      <div class="messageWrapper">
        <h3
          class="message headline"
          v-if="requestFailed"
        >Oops! Looks like were having some troubles. Try again.</h3>
      </div>
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

.messageWrapper {
  width: 100%;
  margin-top: 50px;
}
.message {
  text-align: center;
}
</style>

<script>
import faker from "faker";
import get from "lodash/get";
import isEmpty from "lodash/isEmpty";
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

    const { id } = this.$route.params;

    const handleResponse = response => {
      const userInfo = get(response, "data", {});

      const fullName = `${userInfo.first_name} ${userInfo.last_name}`;

      console.log({
        ...userInfo,
        fullName,
        profileAvatar: faker.image.avatar()
      });

      this.userInfo = {
        ...userInfo,
        fullName,
        profileAvatar: faker.image.avatar()
      };

      this.isLoading = false;
    };

    const handleError = error => {
      this.error = true;
      this.isLoading = false;
    };

    axios
      .get(`/api/profiles/${id}`)
      .then(handleResponse)
      .catch(handleError);
  },

  data() {
    return {
      questions: [],
      userInfo: {},
      error: null,
      isLoading: true
    };
  },

  computed: {
    ...mapGetters(["isLoggedIn", "authUser"]),

    showEditProfileButton() {
      if (!this.isLoggedIn) {
        return false;
      }

      return parseInt(this.$route.params.id, 10) === parseInt(this.authUser.id);
    },

    editProfileLink() {
      const userId = this.authUser.id;

      return `/profile/${userId}/edit`;
    },

    dataFetched() {
      return !this.isLoading && !this.error;
    },

    requestFailed() {
      return !this.isLoading && this.error;
    }
  }
};
</script>