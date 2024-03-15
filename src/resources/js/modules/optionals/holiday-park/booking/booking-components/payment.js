class Payment {
    stage = 4
    constructor() {
        
    }

    update(currentStage) {
        if (currentStage == this.stage) {
            console.log('updating payment info')
        }
    }

    async onLoad(currentStage) {
        if (currentStage == this.stage) {
            console.log('loading payment page')
        }
    }
}

export default Payment