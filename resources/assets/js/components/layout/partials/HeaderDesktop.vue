<template lang="html">
    <header class="header" id="site-header">
        <div class="page-title">
            <h6>favourite page</h6>
        </div>
        <div class="header-content-wrapper">
            <form class="search-bar w-search notification-list friend-requests">
                <div class="form-group with-button">
                    <input class="form-control js-user-search" placeholder="Search here people or pages..." type="text">
                    <button>
                        <svg class="olymp-magnifying-glass-icon">
                            <use xlink:href="/frontend/icons/icons.svg#olymp-magnifying-glass-icon"></use>
                        </svg>
                    </button>
                </div>
            </form>
            <a href="#" class="link-find-friend">Find Friends</a>
            <div class="control-block" v-if="authenticated">
                <div class="control-icon more has-items" @click="markRead(0)">
                    <svg class="olymp-happy-face-icon">
                        <use xlink:href="/frontend/icons/icons.svg#olymp-happy-face-icon"></use>
                    </svg>
                    <div class="label-avatar bg-blue" v-show="count">{{ count }}</div>
                    <div class="more-dropdown more-with-triangle triangle-top-center">
                        <div class="ui-block-title ui-block-title-small">
                            <h6 class="title">{{ $t('messages.friend_popup') }}</h6>
                            <a href="javascript:void(0)">{{ $t('messages.find_friend') }}</a>
                            <a href="javascript:void(0)">{{ $t('messages.settings') }}</a>
                        </div>
                        <div class="mCustomScrollbar" id="notification_list_request" data-mcs-theme="dark">
                            <ul class="notification-list friend-requests">
                                <li v-for="request in listRequest" :class="request.accept ? 'accepted' : ''">
                                    <div class="author-thumb">
                                        <img :src="request.avatar" alt="author">
                                    </div>
                                    <div class="notification-event" v-if="!request.accept">
                                        <a href="#" class="h6 notification-friend">{{ request.userName }}</a>
                                    </div>
                                    <div class="notification-event" v-else>
                                        {{ $t('messages.you_and') }}<a href="#" class="h6 notification-friend">{{ request.userName }}</a>{{ $t('messages.became_friend') }}<a href="#" class="notification-link"></a>.
                                    </div>
                                    <span class="notification-icon" v-if="!request.accept">
                                        <a href="javascript:void(0)"
                                            @click="acceptRequest(request.id, request.userId)"
                                            class="accept-request">
                                            <span class="icon-add without-text">
                                                <svg class="olymp-happy-face-icon">
                                                    <use xlink:href="/frontend/icons/icons.svg#olymp-happy-face-icon"></use>
                                                </svg>
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)"
                                            @click="rejectRequest(request.id, request.userId)"
                                            class="accept-request request-del">
                                            <span class="icon-minus">
                                                <svg class="olymp-happy-face-icon">
                                                    <use xlink:href="/frontend/icons/icons.svg#olymp-happy-face-icon"></use>
                                                </svg>
                                            </span>
                                        </a>
                                    </span>
                                    <div class="more">
                                        <svg class="olymp-three-dots-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-three-dots-icon"></use>
                                        </svg>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <a href="javascript:void(0)" @click="getListRequest()" class="view-all bg-blue" v-show="count">{{ $t('messages.show_more') }}</a>
                    </div>
                </div>
                <div class="control-icon more has-items">
                    <svg class="olymp-chat---messages-icon">
                        <use xlink:href="/frontend/icons/icons.svg#olymp-chat---messages-icon"></use>
                    </svg>
                    <div class="label-avatar bg-purple">{{ countReadMessage }}</div>
                    <div class="more-dropdown more-with-triangle triangle-top-center">
                        <div class="ui-block-title ui-block-title-small">
                            <h6 class="title">Chat / Messages</h6>
                            <a href="#">Mark all as read</a>
                            <a href="#">Settings</a>
                        </div>
                        <div class="mCustomScrollbar" data-mcs-theme="dark" id="notification_messages">
                            <ul class="notification-list chat-message">
                                <li v-for="mess in messages" :class="mess.class">
                                    <div class="author-thumb">
                                        <img :src="mess.showAvatar" alt="author">
                                    </div>
                                    <div class="notification-event">
                                        <a href="#" class="h6 notification-friend">{{ mess.showName }}</a>
                                        <span class="chat-message-item" v-html="mess.sendName + mess.message"></span>
                                        <span class="notification-date">
                                            <time class="entry-date updated" datetime="2004-07-24T18:18" v-if="mess.read">
                                                Read at {{ calendarTime(mess.time) }}
                                            </time>
                                            <time class="entry-date updated" datetime="2004-07-24T18:18" v-else>
                                                {{ calendarTime(mess.time) }}
                                            </time>
                                        </span>
                                    </div>
                                    <span class="notification-icon">
                                        <svg class="olymp-chat---messages-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-chat---messages-icon"></use>
                                        </svg>
                                    </span>
                                    <div class="more">
                                        <svg class="olymp-three-dots-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-three-dots-icon"></use>
                                        </svg>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <a href="javascript:void(0)" class="view-all bg-purple" @click="getMessagesNotification">
                            {{ $t('messages.more_messages') }}
                        </a>
                    </div>
                </div>
                <div class="control-icon more has-items">
                    <svg class="olymp-thunder-icon">
                        <use xlink:href="/frontend/icons/icons.svg#olymp-thunder-icon"></use>
                    </svg>
                    <div class="label-avatar bg-primary">8</div>
                    <div class="more-dropdown more-with-triangle triangle-top-center">
                        <div class="ui-block-title ui-block-title-small">
                            <h6 class="title">Notifications</h6>
                            <a href="#">Mark all as read</a>
                            <a href="#">Settings</a>
                        </div>
                        <div class="mCustomScrollbar" data-mcs-theme="dark">
                            <ul class="notification-list">
                                <li>
                                    <div class="author-thumb">
                                        <img src="/images/avatar62-sm.jpg" alt="author">
                                    </div>
                                    <div class="notification-event">
                                        <div>
                                            <a href="#" class="h6 notification-friend">Mathilda Brinker</a> commented on your new
                                            <a href="#" class="notification-link">profile status</a>.</div>
                                        <span class="notification-date">
                                            <time class="entry-date updated" datetime="2004-07-24T18:18">4 hours ago</time>
                                        </span>
                                    </div>
                                    <span class="notification-icon">
                                        <svg class="olymp-comments-post-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-comments-post-icon"></use>
                                        </svg>
                                    </span>
                                    <div class="more">
                                        <svg class="olymp-three-dots-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-three-dots-icon"></use>
                                        </svg>
                                        <svg class="olymp-little-delete">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-little-delete"></use>
                                        </svg>
                                    </div>
                                </li>
                                <li class="un-read">
                                    <div class="author-thumb">
                                        <img src="/images/avatar63-sm.jpg" alt="author">
                                    </div>
                                    <div class="notification-event">
                                        <div>You and
                                            <a href="#" class="h6 notification-friend">Nicholas Grissom</a> just became friends. Write on
                                            <a href="#" class="notification-link">his wall</a>.</div>
                                        <span class="notification-date">
                                            <time class="entry-date updated" datetime="2004-07-24T18:18">9 hours ago</time>
                                        </span>
                                    </div>
                                    <span class="notification-icon">
                                        <svg class="olymp-happy-face-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-happy-face-icon"></use>
                                        </svg>
                                    </span>
                                    <div class="more">
                                        <svg class="olymp-three-dots-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-three-dots-icon"></use>
                                        </svg>
                                        <svg class="olymp-little-delete">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-little-delete"></use>
                                        </svg>
                                    </div>
                                </li>
                                <li class="with-comment-photo">
                                    <div class="author-thumb">
                                        <img src="/images/avatar64-sm.jpg" alt="author">
                                    </div>
                                    <div class="notification-event">
                                        <div>
                                            <a href="#" class="h6 notification-friend">Sarah Hetfield</a> commented on your
                                            <a href="#" class="notification-link">photo</a>.</div>
                                        <span class="notification-date">
                                            <time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 5:32am</time>
                                        </span>
                                    </div>
                                    <span class="notification-icon">
                                        <svg class="olymp-comments-post-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-comments-post-icon"></use>
                                        </svg>
                                    </span>
                                    <div class="comment-photo">
                                        <img src={{ asset('images/comment-photo1.jpg') }} alt="photo">
                                        <span>“She looks incredible in that outfit! We should see each...”</span>
                                    </div>
                                    <div class="more">
                                        <svg class="olymp-three-dots-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-three-dots-icon"></use>
                                        </svg>
                                        <svg class="olymp-little-delete">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-little-delete"></use>
                                        </svg>
                                    </div>
                                </li>
                                <li>
                                    <div class="author-thumb">
                                        <img src="/images/avatar65-sm.jpg" alt="author">
                                    </div>
                                    <div class="notification-event">
                                        <div>
                                            <a href="#" class="h6 notification-friend">Green Goo Rock</a> invited you to attend to his event Goo in
                                            <a href="#" class="notification-link">Gotham Bar</a>.</div>
                                        <span class="notification-date">
                                            <time class="entry-date updated" datetime="2004-07-24T18:18">March 5th at 6:43pm</time>
                                        </span>
                                    </div>
                                    <span class="notification-icon">
                                        <svg class="olymp-happy-face-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-happy-face-icon"></use>
                                        </svg>
                                    </span>
                                    <div class="more">
                                        <svg class="olymp-three-dots-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-three-dots-icon"></use>
                                        </svg>
                                        <svg class="olymp-little-delete">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-little-delete"></use>
                                        </svg>
                                    </div>
                                </li>
                                <li>
                                    <div class="author-thumb">
                                        <img src="/images/avatar66-sm.jpg" alt="author">
                                    </div>
                                    <div class="notification-event">
                                        <div>
                                            <a href="#" class="h6 notification-friend">James Summers</a> commented on your new
                                            <a href="#" class="notification-link">profile status</a>.</div>
                                        <span class="notification-date">
                                            <time class="entry-date updated" datetime="2004-07-24T18:18">March 2nd at 8:29pm</time>
                                        </span>
                                    </div>
                                    <span class="notification-icon">
                                        <svg class="olymp-heart-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-heart-icon"></use>
                                        </svg>
                                    </span>
                                    <div class="more">
                                        <svg class="olymp-three-dots-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-three-dots-icon"></use>
                                        </svg>
                                        <svg class="olymp-little-delete">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-little-delete"></use>
                                        </svg>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <a href="#" class="view-all bg-primary">View All Notifications</a>
                    </div>
                </div>
                <div class="author-page author vcard inline-items more">
                    <div class="author-thumb">
                        <img alt="author" :src="user.image_thumbnail" class="avatar">
                        <span class="icon-status online"></span>
                        <div class="more-dropdown more-with-triangle">
                            <div class="ui-block-title ui-block-title-small">
                                <h6 class="title">Your Account</h6>
                            </div>
                            <ul class="account-settings">
                                <li>
                                    <router-link :to="{ name: 'setting.profile' }">
                                        <svg class="olymp-menu-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-menu-icon"></use>
                                        </svg>
                                        <span>Profile Settings</span>
                                    </router-link>
                                </li>
                                <li>
                                    <router-link :to="{ name: 'user.timeline', params: { id: user.id }}">
                                        <svg class="olymp-star-icon left-menu-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-star-icon"></use>
                                        </svg>
                                        <span>Your timeline</span>
                                    </router-link>
                                </li>
                                <li>
                                    <a @click="handleLogout">
                                        <svg class="olymp-logout-icon">
                                            <use xlink:href="/frontend/icons/icons.svg#olymp-logout-icon"></use>
                                        </svg>
                                        <span>Log Out</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="ui-block-title ui-block-title-small">
                                <h6 class="title">Chat Settings</h6>
                            </div>
                            <ul class="chat-settings">
                                <li>
                                    <a href="#">
                                        <span class="icon-status online"></span>
                                        <span>Online</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon-status away"></span>
                                        <span>Away</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon-status disconected"></span>
                                        <span>Disconnected</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon-status status-invisible"></span>
                                        <span>Invisible</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="ui-block-title ui-block-title-small">
                                <h6 class="title">Custom Status</h6>
                            </div>
                            <form class="form-group with-button custom-status">
                                <input class="form-control" placeholder="" type="text" value="Space Cowboy">
                                <button class="bg-purple">
                                    <svg class="olymp-check-icon">
                                        <use xlink:href="/frontend/icons/icons.svg#olymp-check-icon"></use>
                                    </svg>
                                </button>
                            </form>
                            <div class="ui-block-title ui-block-title-small">
                                <h6 class="title">About Olympus</h6>
                            </div>
                            <ul>
                                <li>
                                    <a href="#">
                                        <span>Terms and Conditions</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span>FAQs</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span>Careers</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <span>Contact</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <router-link :to="{ name: 'user.timeline', params: { id: user.id } }" class="author-name fn">
                        <div class="author-title">
                            {{ user.name }}
                            <svg class="olymp-dropdown-arrow-icon">
                                <use xlink:href="/frontend/icons/icons.svg#olymp-dropdown-arrow-icon"></use>
                            </svg>
                        </div>
                        <span class="author-subtitle">{{ user.email }}</span>
                    </router-link>
                </div>
            </div>
            <!--End: control-block -->

            <div class="control-block" v-else>
                <router-link to="/login">Login</router-link> |
                <router-link to="/register">Register</router-link>
            </div>
        </div>
    </header>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import {
    logout,
    showNotification,
    getListRequest,
    rejectRequest,
    markRead,
    acceptRequest
} from '../../../router/router'
import { post, get } from '../../../helpers/api'
import noty from '../../../helpers/noty'

export default {
    data: () => ({
        messages: [],
        paginate: 0,
        continue: true,
        listRequest: [],
        count: 0,
        skipFriend: 0,
        continueForGetListRequest: true,
        countReadMessage: 0
    }),
    created () {
        this.getMessagesNotification()
        this.getListRequest()
    },
    computed: {
        ...mapState('auth', {
            authenticated: state => state.authenticated,
            user: state => state.user,
            groups: state => state.groups
        })
    },
    methods: {
        ...mapActions('auth', [
            'logout',
            'getListFollow'
        ]),
        handleLogout() {
            post(logout).then(res => {
                this.logout()
                this.$router.push('/login')
            }).catch(err => {
                this.$router.push('/')
            })
        },
        getMessagesNotification() {
            if (this.continue) {
                get(`${showNotification}?paginate=${this.paginate}`)
                    .then(res => {
                        if (res.data.status == 200) {
                            let noty = res.data.notifications

                            for (var index = 0; index < noty.length; index++) {
                                let isSendToUser = Number.isInteger(Number(noty[index].content.receive))
                                let mess = {
                                    form: noty[index].content.userId,
                                    sendName: (noty[index].content.userId == this.user.id)
                                        ? this.$i18n.t('messages.you')
                                        : noty[index].content.name + ": ",
                                    to: noty[index].content.receive,
                                    groupChat: noty[index].content.groupKey,
                                    message: noty[index].content.message,
                                    showName: (noty[index].content.userId == this.user.id || !isSendToUser)
                                        ? noty[index].content.nameReceive
                                        : noty[index].content.name,
                                    showAvatar: (noty[index].content.userId == this.user.id || !isSendToUser)
                                        ? noty[index].content.avatarReceive
                                        : noty[index].content.avatar,
                                    class: isSendToUser ? (noty[index].isRead ? "" : "message-unread") : "group-chat",
                                    time: noty[index].isRead ? noty[index].time : noty[index].content.time,
                                    read: noty[index].isRead
                                }

                                this.countReadMessage = !mess.read
                                    ? (this.countReadMessage + 1)
                                    : this.countReadMessage

                                this.messages.push(mess)
                            }

                            this.paginate = res.data.paginate
                        }

                        this.continue = res.data.continue
                    })
                    .catch(err => {
                        const message = this.$i18n.t('messages.load_notification_message_fail')
                        noty({ text: message, container: false, force: true})
                    })
            }
        },
        receiveMessage(data, option) {
            var socketData = JSON.parse(data)

            if (socketData.success ) {
                var message = JSON.parse(socketData.message)
                let index = this.messages.findIndex(mess => mess.groupChat == socketData.groupChat)

                let mess = {
                    from: socketData.from,
                    sendName: (socketData.from == this.user.id)
                        ? this.$i18n.t('messages.you')
                        : socketData.name + ": ",
                    to: socketData.to,
                    groupChat: socketData.groupChat,
                    message: message.message,
                    showName: (socketData.from == this.user.id || !option)
                        ? message.nameReceive
                        : message.name,
                    showAvatar: (socketData.from == this.user.id || !option)
                        ? message.avatarReceive
                        : message.avatar,
                    class: Number.isInteger(socketData.to) ? "" : "group-chat",
                    time: message.time,
                    read: false
                }

                if (index == -1) {
                    this.messages.unshift(mess)
                    this.countReadMessage += 1
                } else {
                    this.messages.splice(index, 1)
                    this.messages.unshift(mess)
                }

                this.paginate++
            }
        },
        calendarTime(time) {
            return moment(time).calendar()
        },
        getListRequest() {
            if (this.continueForGetListRequest) {
                get(`${getListRequest}?skip=${this.skipFriend}`)
                    .then(res => {
                        let data = res.data.notifications

                        for (var index = 0; index < data.length; index++) {
                            let user = {
                                id: data[index].id,
                                userId: data[index].data.form.id,
                                userName: data[index].data.form.name,
                                avatar: data[index].data.form.image_small,
                                accept: false
                            }

                            this.listRequest.push(user)
                        }

                        this.count = res.data.unread
                        this.skipFriend = res.data.skip
                        this.continueForGetListRequest = res.data.continue
                    })
                    .catch(err => {
                        const message = this.$i18n.t('messages.connection_error')
                        noty({ text: message, container: false, force: true })
                    })
            }
        },
        acceptRequest(id, userId) {
            post(`${acceptRequest}/${userId}`, { id: id })
                .then(res => {
                    let index = this.listRequest.findIndex(request => request.userId == userId)

                    if (index != -1) {
                        this.$socket.emit('acceptRequest', {
                            userId: userId,
                            acceptId: this.user.id,
                            avatar: this.user.image_thumbnail,
                            name: this.user.name,
                            receiveAvatar: this.listRequest[index].avatar,
                            receiveName: this.listRequest[index].userName
                        })

                        this.listRequest.splice(index, 1)
                    }
                })
        },
        rejectRequest(id, userId) {
            post(rejectRequest, { id: id, userId: userId })
                .then(res => {
                    if (res.data.http_status.code == 200) {
                        this.count = (this.count > 0) ? this.count - 1 : this.count
                        let index = this.listRequest.findIndex(request => request.id == id)

                        if (index != -1) {
                            this.listRequest.splice(index, 1)
                        }
                    }
                })
                .catch(err => {
                    const message = this.$i18n.t('messages.connection_error')
                    noty({ text: message, container: false, force: true })
                })
        },
        markRead(type) {
            if (this.count) {
                post(markRead, { type: type })
                    .then(res => {
                        if (res.data.http_status.code == 200) {
                            this.count = res.data.unread
                        }
                    })
                    .catch(err => {
                        const message = this.$i18n.t('messages.connection_error')
                        noty({ text: message, container: false, force: true })
                    })
            }
        }
    },
    mounted() {
        const vm = this
        $('#notification_messages').on('scroll', function() {
            if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                vm.getMessagesNotification()
            }
        })
    },
    sockets: {
        singleChat: function (data) {
            this.receiveMessage(data, true)
        },
        groupChat: function (data) {
            this.receiveMessage(data, false)
        },
        noty: function (data) {
            data = JSON.parse(data)

            if (data.type) {
                let user = {
                    id: null,
                    userId: data.noty.id,
                    userName: data.noty.name,
                    avatar: data.noty.image_small
                }

                this.listRequest.push(user)
                this.count += 1
            } else {
                let index = this.listRequest.findIndex(user => user.userId == data.noty.id)

                if (index != -1) {
                    this.listRequest.splice(index, 1)
                    this.count -= 1
                }
            }
        },
        acceptRequestSuccess: function (data) {
            if (data.status) {
                this.getListFollow()
                let socketData = data.data
                let mess = {
                    id: null,
                    avatar: (socketData.acceptId == this.user.id)
                        ? socketData.receiveAvatar
                        : socketData.avatar,
                    userName: (socketData.acceptId == this.user.id)
                        ? socketData.receiveName
                        : socketData.name,
                    accept: true
                }

                this.listRequest.unshift(mess)
            }
        }
    }
}
</script>

<style lang="scss">
.author-thumb {
    .avatar {
        width: 36px;
        height: 36px;
    }
}

#notification_messages, #notification_list_request {
    overflow-y: scroll !important;
}
</style>
