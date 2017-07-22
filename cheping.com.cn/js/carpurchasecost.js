function CarPurchaseCost() {
    this.carCostParam = {
        reSetCustom : true,
        //�����۸�
        carPrice: 0,
        //�׸��Զ���
        prepaymentCustom: 0,
        //�׸�����
        prepaymentPercent: 0.1,
        //��������
        loanYears: 1,
        //�Զ������Ʒ���
        licenseTaxCustom: 0,
        //�Զ��峵��ʹ��˰
        usageTaxCustom: 0,
        //����
        displacement: 9,
        //��λ��
        seatCount: 6,
        //�Ƿ���ڳ�
        isImport: 0,
        //������������ �⸶���
        thirdInsureClaim: 50000,
        //�Զ��峵����Ա������
        passengerInsureCustom: 0,
        //�������� �⸶���
        carBodyInsureClaim: 2000,
        //�Ƿ�ѡ
        CommInsureCheck: {
            //������������
            thirdCheck: true,
            //������ʧ��
            damageCheck: false,
            //ȫ��������
            stolenCheck: false,
            //��������������
            glassCheck: false,
            //��ȼ��ʧ��
            combustCheck: false,
            //����������Լ��
            noDeductibleCheck: false,
            //�޹�������
            noLiabilityCheck: false,
            //������Ա������
            passengerCheck: false,
            //��������
            carBodyCheck: false
        }
    }

    this.getPositive = function (val) {
        if (parseFloat(val) < 0) {
            return 0;
        }

        return val;
    }

    //�׸���
    this.getPrepayment = function () {
        var carPrice = this.carCostParam.carPrice;
        var percent = this.carCostParam.prepaymentPercent;
        if (!this.carCostParam.reSetCustom && this.carCostParam.prepaymentCustom != 0) {
            return this.carCostParam.prepaymentCustom;
        }

        if (percent == 0) {
            return this.carCostParam.prepaymentCustom;
        }

        return carPrice * percent;
    }

    //�����
    this.getBankLoan = function () {
        var _this = this;
        var carPrice = this.carCostParam.carPrice;
        return carPrice - this.getPrepayment();
    }

    //�¸��� 
    this.getMonthPay = function () {
        var bankLoan = this.getBankLoan(),
        loanYears = this.carCostParam.loanYears;
        months = loanYears * 12,
        rate = 0;
        if (loanYears == 1) {
            rate = 0.0656 / 12;
        } else if (loanYears == 2) {
            rate = 0.0665 / 12;
        } else if (loanYears == 3) {
            rate = 0.0665 / 12;
        } else if (loanYears == 4) {
            rate = 0.069 / 12;
        } else if (loanYears == 5) {
            rate = 0.069 / 12;
        }

        return bankLoan * ((rate * Math.pow(1 + rate, months)) / (Math.pow(1 + rate, months) - 1));
    }


    //����˰
    this.getPurchaseTax = function () {
        return (this.carCostParam.carPrice / 1.17) * 0.1;
    }

    //���Ʒ���
    this.getLicenseTax = function () {
        if (!this.carCostParam.reSetCustom) {
            return this.carCostParam.licenseTaxCustom;
        }
        return 500;
    }

    //����ʹ��˰
    this.getUsageTax = function (displacement) {
        var displacement = displacement || this.carCostParam.displacement; //����
        if (!this.carCostParam.reSetCustom) {
            return this.carCostParam.usageTaxCustom;
        }
        if (displacement <= 1.0) {
            return 300;
        } else if (displacement > 1.0 && displacement <= 1.6) {
            return 420;
        } else if (displacement > 1.6 && displacement <= 2.0) {
            return 480
        } else if (displacement > 2.0 && displacement <= 2.5) {
            return 900
        } else if (displacement > 2.5 && displacement <= 3.0) {
            return 1920
        } else if (displacement > 3.0 && displacement <= 4.0) {
            return 3480
        } else if (displacement > 4.0) {
            return 5280
        }
        return 480;
    }

    //��ǿ��
    this.getTrafficInsurance = function () {
        var seatCount = this.carCostParam.seatCount; //��λ��
        if (seatCount < 7) {
            return 950;
        }

        return 1100;
    }

    //������������
    this.getThirdInsurance = function () {
        //û��ѡ��
        if (!this.carCostParam.CommInsureCheck.thirdCheck) {
            return 0;
        }
        var thirdInsureClaim = this.carCostParam.thirdInsureClaim;
        var seatCount = this.carCostParam.seatCount; //��λ��
        if (seatCount < 7) {
            switch (thirdInsureClaim) {
                case 50000:
                    return 516;
                case 100000:
                    return 746;
                case 200000:
                    return 924;
                case 500000:
                    return 1252;
                case 1000000:
                    return 1630;
                default:
                    return 746;
            }
        } else {
            switch (thirdInsureClaim) {
                case 50000:
                    return 478;
                case 100000:
                    return 674;
                case 200000:
                    return 821;
                case 500000:
                    return 1094;
                case 1000000:
                    return 1425;
                default:
                    return 674;
            }
        }
        return 746;
    }

    //������ʧ��
    this.getDamageInsurance = function () {
        //û��ѡ��
        if (!this.carCostParam.CommInsureCheck.damageCheck) {
            return 0;
        }
        var carPrice = this.carCostParam.carPrice;
        var seatCount = this.carCostParam.seatCount; //��λ��
        var base = 459;
        if (seatCount > 6) {
            base = 550;
        }
        return base + carPrice * 0.01088;
    }

    //ȫ��������
    this.getStolenInsurance = function () {
        //û��ѡ��
        if (!this.carCostParam.CommInsureCheck.stolenCheck) {
            return 0;
        }
        var carPrice = this.carCostParam.carPrice;
        var seatCount = this.carCostParam.seatCount; //��λ��       
        if (seatCount > 6) {
            return 119 + carPrice * 0.00374;
        } else {
            return 102 + carPrice * 0.004505;
        }        
    }

    //��������������
    this.getGlassInsurance = function () {
        //û��ѡ��
        if (!this.carCostParam.CommInsureCheck.glassCheck) {
            return 0;
        }
        var carPrice = this.carCostParam.carPrice;
        var isImport = this.carCostParam.isImport;
        if (isImport == 1) {
            return carPrice * 0.0025;
        } else {
            return carPrice * 0.0015;
        }
    }

    //��ȼ��ʧ��
    this.getCombustInsurance = function () {
        //û��ѡ��
        if (!this.carCostParam.CommInsureCheck.combustCheck) {
            return 0;
        }
        var carPrice = this.carCostParam.carPrice;
        return carPrice * 0.0015;
    }

    //����������Լ��
    this.getNoDeductibleInsurance = function () {
        //û��ѡ��
        if (!this.carCostParam.CommInsureCheck.noDeductibleCheck) {
            return 0;
        }
        var damageInsurance = this.getDamageInsurance(),
        thirdInsurance = this.getThirdInsurance();
        if (damageInsurance == undefined || thirdInsurance == undefined) {
            return 0;
        }

        return (damageInsurance + thirdInsurance) * 0.2;
    }

    //�޹�������
    this.getNoLiabilityInsurance = function () {
        //û��ѡ��
        if (!this.carCostParam.CommInsureCheck.noLiabilityCheck) {
            return 0;
        }
        var thirdInsurance = this.getThirdInsurance();
        if (thirdInsurance == undefined) {
            return 0;
        }

        return (thirdInsurance) * 0.2;
    }

    //������Ա������
    this.getPassengerInsurance = function () {
        //û��ѡ��
        if (!this.carCostParam.CommInsureCheck.passengerCheck) {
            return 0;
        }
        if (!this.carCostParam.reSetCustom) {
        	if(this.carCostParam.passengerInsureCustom == 0){
        		return 50;
        	}
            return this.carCostParam.passengerInsureCustom;
        }
        return 50;
    }

    //��������
    this.getCarBodyInsurance = function () {
        //û��ѡ��
        if (!this.carCostParam.CommInsureCheck.carBodyCheck) {
            return 0;
        }
        var carPrice = this.carCostParam.carPrice;
        var carBodyInsureClaim = this.carCostParam.carBodyInsureClaim; //�⸶���
        if (carBodyInsureClaim == 2000) {
            if (carPrice > 0 && carPrice <= 300000) {
                return 400
            }
            if (carPrice > 300000 && carPrice <= 500000) {
                return 585
            }
            if (carPrice > 500000) {
                return 850
            }
            return 0;

        } else if (carBodyInsureClaim == 5000) {
            if (carPrice > 0 && carPrice <= 300000) {
                return 570
            }
            if (carPrice > 300000 && carPrice <= 500000) {
                return 900
            }
            if (carPrice > 500000) {
                return 1100
            }
            return 0;
        } else if (carBodyInsureClaim == 10000) {
            if (carPrice > 0 && carPrice <= 300000) {
                return 760
            }
            if (carPrice > 300000 && carPrice <= 500000) {
                return 1170
            }
            if (carPrice > 500000) {
                return 1500
            }
            return 0;
        } else if (carBodyInsureClaim == 20000) {
            if (carPrice > 0 && carPrice <= 300000) {
                return 1140
            }
            if (carPrice > 300000 && carPrice <= 500000) {
                return 1780
            }
            if (carPrice > 500000) {
                return 2250
            }
            return 0;
        }

        return 0;
    }
}

CarPurchaseCost.prototype.getCarPurchaseCost = function (costParam) {
    //    var getPrepayment, getBankLoan, getMonthPay, getPurchaseTax, getLicenseTax, getUsageTax, getTrafficInsurance, getThirdInsurance,
    //    getDamageInsurance, getStolenInsurance, getGlassInsurance, getCombustInsurance, getNoDeductibleInsurance, getNoLiabilityInsurance,
    //    getPassengerInsurance, getCarBodyInsurance, 
    var carLoanFee, carPurchaseTax, carInsurance, carPurchaseFee;
    //��ֵ
    for (key in costParam) {
        if (costParam[key] !== undefined) {
            this.carCostParam[key] = costParam[key]
        }
    }

    carLoanFee = {
        //��������
        years: 1,
        //��������
        months: 12,
        //�׸�
        prepayment: 0,
        //�����
        bankLoan: 0,
        //�¸���
        monthPay: 0,
        //�����ܶ�
        getRepayment: function () {
            return this.monthPay * this.months;
        }
    }

    carPurchaseTax = {
        //����˰
        purchaseTax: 0,
        //���Ʒ���
        licenseTax: 0,
        //����ʹ��˰
        usageTax: 0,
        //˰���ۺ�
        getTotal: function () {
            return this.purchaseTax + this.licenseTax + this.usageTax;
        }
    }

    carInsurance = {
        //��ͨ�¹�����ǿ�Ʊ���
        trafficInsurance: 0,
        //������������
        thirdInsurance: 0,
        //������ʧ��
        damageInsurance: 0,
        //ȫ��������
        stolenInsurance: 0,
        //��������������
        glassInsurance: 0,
        //��ȼ��ʧ��
        combustInsurance: 0,
        //����������Լ��
        noDeductibleInsurance: 0,
        //�޹�������
        noLiabilityInsurance: 0,
        //������Ա������
        passengerInsurance: 0,
        //��������
        carBodyInsurance: 0,
        //��ҵ���ܺ�
        getCommerceTotal: function () {
            return this.thirdInsurance + this.damageInsurance + this.stolenInsurance + this.glassInsurance + this.combustInsurance + this.noDeductibleInsurance +
            this.noLiabilityInsurance + this.passengerInsurance + this.carBodyInsurance;
        },
        //�����ܺ�
        getInsuranceTotal: function () {
            return this.trafficInsurance + this.thirdInsurance + this.damageInsurance + this.stolenInsurance + this.glassInsurance + this.combustInsurance + this.noDeductibleInsurance +
            this.noLiabilityInsurance + this.passengerInsurance + this.carBodyInsurance;
        }
    }

    carPurchaseFee = {
        carPrice: 0,
        carLoanFee: carLoanFee,
        carPurchaseTax: carPurchaseTax,
        carInsurance: carInsurance,
        //��ҵ�����ܷ���
        getCommerceInsurance: function () {
            return this.carInsurance.getCommerceTotal();
        },
        //���ڸ����
        getTotalPrepayment: function () {
            return this.carLoanFee.prepayment + this.carPurchaseTax.getTotal() + this.carInsurance.getInsuranceTotal(); ;
        },
        //ȫ���Ԥ�ƻ���
        getTotal: function () {
            return Number(this.carPrice) + Number(this.carPurchaseTax.getTotal()) + Number(this.carInsurance.getInsuranceTotal());
        },
        //�������ܻ���
        getTotalLoan: function () {
            return this.carLoanFee.prepayment + this.carLoanFee.getRepayment() + this.carPurchaseTax.getTotal() + this.carInsurance.getInsuranceTotal();
        },
        //�����򳵱�ȫ���򳵶໨��
        getLoanMoreCost: function () {
            if (this.getTotalLoan() < this.getTotal()) {
                return 0;
            }
            return this.getTotalLoan() - this.getTotal();
        },
        //��Ҫ�����ۺ�
        getTotalTax: function () {
            return this.carPurchaseTax.getTotal() + this.carInsurance.trafficInsurance;
        },
        //��˾����
        getTotalInsurance: function () {
            return carInsurance.trafficInsurance + this.carInsurance.getCommerceTotal();
        },
        //�г���
        getMarketCommerce: function () {
            return carInsurance.trafficInsurance + Math.round((this.carInsurance.getCommerceTotal() * 0.9));
        }
    }




    carPurchaseFee.carPrice = this.getPositive(this.carCostParam.carPrice); //�����۸�
    carPurchaseFee.carLoanFee.years = this.getPositive(this.carCostParam.loanYears); //��������
    carPurchaseFee.carLoanFee.months = this.getPositive(this.carCostParam.loanYears * 12); //��������
    carPurchaseFee.carLoanFee.prepayment = this.getPositive(Math.round(this.getPrepayment())); //�׸���
    carPurchaseFee.carLoanFee.bankLoan = this.getPositive(Math.round(this.getBankLoan())); //�����
    carPurchaseFee.carLoanFee.monthPay = this.getPositive(Math.round(this.getMonthPay())); //�¸���
    carPurchaseFee.carPurchaseTax.purchaseTax = this.getPositive(Math.round(this.getPurchaseTax())); //����˰
    carPurchaseFee.carPurchaseTax.licenseTax = this.getPositive(Math.round(this.getLicenseTax())); //����˰
    carPurchaseFee.carPurchaseTax.usageTax = this.getPositive(Math.round(this.getUsageTax())); //����ʹ��˰
    carPurchaseFee.carInsurance.trafficInsurance = this.getPositive(Math.round(this.getTrafficInsurance())); // ��ǿ��
    carPurchaseFee.carInsurance.thirdInsurance = this.getPositive(Math.round(this.getThirdInsurance())); //������������
    carPurchaseFee.carInsurance.damageInsurance = this.getPositive(Math.round(this.getDamageInsurance())); //������ʧ��
    carPurchaseFee.carInsurance.stolenInsurance = this.getPositive(Math.round(this.getStolenInsurance())); //ȫ��������
    carPurchaseFee.carInsurance.glassInsurance = this.getPositive(Math.round(this.getGlassInsurance())); //��������������
    carPurchaseFee.carInsurance.combustInsurance = this.getPositive(Math.round(this.getCombustInsurance())); //��ȼ��ʧ��
    carPurchaseFee.carInsurance.noDeductibleInsurance = this.getPositive(Math.round(this.getNoDeductibleInsurance())); //����������Լ��
    carPurchaseFee.carInsurance.noLiabilityInsurance = this.getPositive(Math.round(this.getNoLiabilityInsurance())); //�޹�������
    carPurchaseFee.carInsurance.passengerInsurance = this.getPositive(Math.round(this.getPassengerInsurance())); //������Ա������
    carPurchaseFee.carInsurance.carBodyInsurance = this.getPositive(Math.round(this.getCarBodyInsurance())); //��������

    return carPurchaseFee;

}