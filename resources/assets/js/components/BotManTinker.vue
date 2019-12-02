<template>
    <div id="genie-wrapper">
        <div class="arrow"></div>
        <ul class="ChatLog">
            <li class="ChatLog__entry" v-for="message in messages" :class="{'ChatLog__entry_mine': message.isMine}">
                <img class="ChatLog__avatar" :src="bot_image" />
                <p class="ChatLog__message">{{ message.text }}</p>
            </li>
        </ul>

        <!-- <span v-if="isTyping">Typing...</span> -->
        <input type="text" class="ChatInput form-control" 
        @keyup.enter="sendMessage"  @keypress="updateType"
         v-model="newMessage" placeholder="Say hello to Genie">
    </div>
</template>

<style>
    #genie-wrapper {
        height: 80vh;
        display: flex;
        justify-content: space-between;
        flex-direction: column;
    }
    input.ChatInput {
        width: 100%;
        height: 25px;
        border-radius: 5px;
        border: none;
        padding: 30px 10px;
            background-color: #494b54;
            color: #949ba2;
    border: none;
    border-radius: 4px;
    }

    ul.ChatLog {
        list-style: none;
    }

    .ChatLog {
        max-width: 100%;
        width: 100%;
        padding : 20px;
        margin: 0 auto;
        height: 80%;
        overflow-y: scroll;
    }
    .ChatLog .ChatLog__entry {
        margin: .5em;
    }

    .ChatLog__entry {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        max-width: 100%;
    }

    .ChatLog__entry.ChatLog__entry_mine {
        flex-direction: row-reverse;
    }

    .ChatLog__avatar {
        flex-shrink: 0;
        flex-grow: 0;
        z-index: 1;
        height: 50px;
        width: 50px;
        border-radius: 25px;

    }

    .ChatLog__entry.ChatLog__entry_mine
    .ChatLog__avatar {
        display: none;
    }

    .ChatLog__entry .ChatLog__message {
        position: relative;
        margin: 0 12px;
    }

    .ChatLog__entry .ChatLog__message::before {
        position: absolute;
        right: auto;
        bottom: .6em;
        left: -12px;
        height: 0;
        content: '';
        border: 6px solid transparent;
        border-right-color: #ddd;
        z-index: 2;
    }

    .ChatLog__entry.ChatLog__entry_mine .ChatLog__message::before {
        right: -12px;
        bottom: .6em;
        left: auto;
        border: 6px solid transparent;
        border-left-color: #08f;
    }

    .ChatLog__message {
        background-color: #ddd;
        color: #222;
            padding: .5em 1em;
        border-radius: 4px;
        /*font-weight: lighter;*/
        max-width: 70%;
    }

    .ChatLog__entry.ChatLog__entry_mine .ChatLog__message {
        word-wrap: break-word;
        border-top: 1px solid #07f;
        border-bottom: 1px solid #07f;
        background-color: #08f;
        color: #fff;
    }


</style>

<script>
const $ = require('jquery');
    const axios = require('axios');
    const API_ENDPOINT = '/genie/handle';

    export default {
        data() {
            return {
                messages: [],
                newMessage: null,
                isTyping: false
            };
        },

        props: ['bot_image', 'userId'],

        methods: {
            _addMessage(text, attachment, isMine) {
                this.messages.push({
                    'isMine': isMine,
                    'user': isMine ? '👨' : '🤖',
                    'text': text,
                    'attachment': attachment || {},
                });
            },

            sendMessage() {
                let messageText = this.newMessage;
                this.newMessage = '';
                if (messageText === 'clear') {
                    this.messages = [];
                    return;
                }

                this._addMessage(messageText, null, true);

                axios.post(API_ENDPOINT, {
                    driver: 'web',
                    userId: this.userId,
                    message: messageText
                }).then(response => {
                    let messages = response.data.messages || [];
                    messages.forEach(msg => {
                        this._addMessage(msg.text, msg.attachment, false);
                    });
                    $('.ChatLog').stop().animate({
                          scrollTop: $(".ChatLog")[0].scrollHeight
                        }, 800);
                    console.log(response);
                }, response  => {
                });
                this.isTyping = false;
            },

            updateType() {
                this.isTyping = true;
            }
        }
    }
</script>
