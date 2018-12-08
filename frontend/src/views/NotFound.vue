<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>
      <v-flex xs12 sm8 md5 class="content">
        <div class="robotWrapper">
          <icon-robot width="185" height="185"></icon-robot>
        </div>
        <div class="robotShadow"></div>
        <div class="textWrapper">
          <h2 class="display-1 center">Whoops!</h2>
        </div>
        <div class="textWrapper">
          <p class="headline center">We couldn't find the page you
            <br>were looking for.
          </p>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<style>
.content {
    display: flex;
    align-items: center;
    flex-direction: column;
}

.robotWrapper {
    animation: floating 3s ease-in-out infinite;
}
.robotShadow {
    width: 128px;
    height: 16px;
    background-color: rgba(234, 234, 234, 0.75);
    margin: 40px auto 30px auto;
    border-radius: 50%;
    animation: floatingShadow 3s ease-in-out infinite;
}

.center {
    text-align: center;
}

.textWrapper {
    margin: 10px 0;
}

@keyframes floating {
    0% {
        transform: translate3d(0, 0, 0);
    }
    45% {
        transform: translate3d(0, -10%, 0);
    }
    55% {
        transform: translate3d(0, -10%, 0);
    }
    100% {
        transform: translate3d(0, 0, 0);
    }
}

@keyframes floatingShadow {
    0% {
        transform: scale(1);
    }
    45% {
        transform: scale(0.85);
    }
    55% {
        transform: scale(0.85);
    }
    100% {
        transform: scale(1);
    }
}
</style>


<script>
import IconRobot from "@/components/icons/IconRobot.vue";

export default {
    components: {
        IconRobot
    }
};
</script>
