<?php

declare(strict_types=1);

namespace Norsys\Package\Controller\Adminhtml\Invoice;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\DataObject;
use Magento\User\Model\User;
use Magento\User\Model\UserFactory;
use Norsys\Package\Model\CrbtFactory;
use Norsys\Package\Model\Package;
use Norsys\Package\Model\PackageFactory;
use Norsys\Package\Model\PackageProductStockFactory;
use Norsys\ProductStock\Model\ProductStockFactory;

class Printing extends Action {

    protected $fileFactory;

    /** @var PackageFactory */
    protected PackageFactory $_packageFactory;

    /** @var UserFactory */
    protected UserFactory $_userFactory;

    protected $date;

    /** @var CrbtFactory */
    protected CrbtFactory $_crbtFactory;

    /** @var PackageProductStockFactory */
    protected PackageProductStockFactory $_packageProductStockFactory;

    /** @var ProductStockFactory */
    protected ProductStockFactory $_productStockFactory;

    public function __construct(
        Context                                     $context,
        FileFactory                                 $fileFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        CrbtFactory                                 $crbtFactory,
        UserFactory                                 $userFactory,
        PackageProductStockFactory                  $packageProductStockFactory,
        ProductStockFactory                         $productStockFactory,
        PackageFactory                              $packageFactory
    ) {

        $this->fileFactory = $fileFactory;
        $this->date = $date;
        $this->_crbtFactory = $crbtFactory;
        $this->_packageFactory = $packageFactory;
        $this->_userFactory = $userFactory;
        $this->_packageProductStockFactory = $packageProductStockFactory;
        $this->_productStockFactory = $productStockFactory;
        parent::__construct($context);
    }

    public function getPackageUser(): ?User {
        if ($packageId = $this->getRequest()->getParam('id')) {
            if ($package = $this->_packageFactory->create()->load($packageId)) {
                /** @var string $userId */
                $userId = $package->getUserClId();
                return $this->_userFactory->create()->load($userId);
            }
        }
        return NULL;
    }

    /**
     * @return null|\Norsys\Package\Model\Package
     */
    public function getPackage(): ?Package {
        if ($packageId = $this->getRequest()->getParam('id')) {
            return $this->_packageFactory->create()->load($packageId);
        }
        return NULL;
    }
    
    /**
     * @return \Magento\Framework\DataObject|null
     */
    public function getCRBT(): ?DataObject {
        if ($packageId = $this->getRequest()->getParam('id')) {
            /** @var \Norsys\Package\Model\ResourceModel\Crbt\Collection $crbt */
            $crbt = $this->_crbtFactory->create()->getCollection();
            return $crbt->addFieldToFilter('package_id', ['eq' => $packageId])
                ->getLastItem();
        }
        return NULL;
    }

    /**
     * @return null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getPackageProduct() {
        if ($packageId = $this->getRequest()->getParam('id')) {
            return $this->_packageProductStockFactory->create()
                ->getCollection()
                ->addFieldToFilter('package_id', ['eq' => $packageId])
                ->join(
                    [
                        'productStock' => $this->_productStockFactory->create()
                            ->getResource()
                            ->getMainTable(),
                    ],
                    'main_table.product_stock_id= productStock.entity_id'
                );
        }
        return NULL;
    }

    function execute() {
        $productPackage = $this->getPackageProduct();
        $pdf = new \Zend_Pdf();
        $pdf->pages[] = $pdf->newPage(\Zend_Pdf_Page::SIZE_A4);
        $page = $pdf->pages[0];
        $style = new \Zend_Pdf_Style();
        $style->setLineColor(new \Zend_Pdf_Color_Rgb(0, 0, 0));
        $font = \Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_TIMES);
        $style->setFont($font, 13);
        $page->setStyle($style);
        $width = $page->getWidth();
        $hight = $page->getHeight();
        $x = 30;
        $pageTopalign = 850;
        $this->y = 850 - 100;
        $style->setFont($font, 14);
        $page->setStyle($style);
        $page->drawRectangle(30, $this->y - 30, $page->getWidth() - 30, $this->y + 75, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $style->setFont($font, 16);
        $page->setStyle($style);
        $page->drawText(__("INVOICE"), $x + 5, $this->y + 50, 'UTF-8');
        $style->setFont($font, 10);
        $page->setStyle($style);
        $date = $this->date->gmtDate('d-m-Y');
        $page->drawText(__("Invoice Number : #000%1", $this->getRequest()
            ->getParam("id")), $x + 5, $this->y + 33, 'UTF-8');
        $page->drawText(__("Sender Fullname : %1", $this->getPackageUser()
                ->getFirstName() . ' ' . $this->getPackageUser()
                ->getLastName()), $x + 5, $this->y + 16, 'UTF-8');
        $page->drawText(__("Email : %1", $this->getPackageUser()
            ->getEmail()), $x + 5, $this->y - 1, 'UTF-8');
        $page->drawText(__("Date Invoice : %1", $date), $x + 5, $this->y - 18, 'UTF-8');

        //*****
        $style->setFont($font, 16);
        $page->setStyle($style);
        $page->drawText(__("TRUST PARCEL"), $x + 350, $this->y + 50, 'UTF-8');
        $style->setFont($font, 10);
        $page->setStyle($style);
        $date = $this->date->gmtDate('d-m-Y');
        $page->drawText(__(" Phone : 05243-00462"), $x + 350, $this->y + 33, 'UTF-8');
        $page->drawText(__(" Email : trustparcelservice@gmail.com"), $x + 350, $this->y + 16, 'UTF-8');
        $page->drawText(__(" Address : Lot. Koutoubia villa n° 39,"), $x + 350, $this->y - 1, 'UTF-8');
        $page->drawText(__("Quartier, Marrakech 40080 "), $x + 350, $this->y - 18, 'UTF-8');

        //****
        $page->drawRectangle(30, $this->y - 55, $page->getWidth() - 30, $this->y - 30, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $style->setFont($font, 11);
        $page->setStyle($style);
        $page->drawText(__("Receiver Information"), $x + 5, $this->y - 46, 'UTF-8');
        $page->drawText(__("Receiver Information"), $x + 5, $this->y - 46, 'UTF-8');
        $page->drawText(__("Shipping Address"), $x + 350, $this->y - 46, 'UTF-8');
        $page->drawText(__("Shipping Address"), $x + 350, $this->y - 46, 'UTF-8');

        //****
        $page->drawRectangle(30, $this->y - 55, $page->getWidth() - 30, $this->y - 105, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $style->setFont($font, 10);
        $page->setStyle($style);
        $page->drawText(__("Receiver Name : %1", $this->getPackage()
            ->getData('receiverFullName')), $x + 5, $this->y - 65, 'UTF-8');
        $page->drawText(__("Receiver Phone: %1", $this->getPackage()
            ->getData('phoneNumber')), $x + 5, $this->y - 81, 'UTF-8');
        $page->drawText(__("City : %1", $this->getPackage()
            ->getCity()), $x + 350, $this->y - 65, 'UTF-8');
        $page->drawText(__("Street : %1", $this->getPackage()
            ->getStreet()), $x + 350, $this->y - 81, 'UTF-8');
        $page->drawText(__("Zip Code: %1", $this->getPackage()
            ->getData('zipCode')), $x + 350, $this->y - 97, 'UTF-8');

        //****
        $page->drawRectangle(30, $this->y - 105, $page->getWidth() - 30, $this->y - 130, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $style->setFont($font, 11);
        $page->setStyle($style);
        $page->drawText(__("Shipping Information"), $x + 5, $this->y - 121, 'UTF-8');
        $page->drawText(__("Shipping Information"), $x + 5, $this->y - 121, 'UTF-8');
        $page->drawText(__("Cash On Delivery Information"), $x + 350, $this->y - 121, 'UTF-8');
        $page->drawText(__("Cash On Delivery Information"), $x + 350, $this->y - 121, 'UTF-8');

        //***
        $page->drawRectangle(30, $this->y - 130, $page->getWidth() - 30, $this->y - 165, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        $style->setFont($font, 10);
        $page->setStyle($style);
        $page->drawText(__("Package Weight : %1", $this->getPackage()
                ->getWeight() . ' Kg'), $x + 5, $this->y - 140, 'UTF-8');
        $page->drawText(__("Total Shipping Charges : %1", $this->getPackage()
                ->getPrice() . ' DH'), $x + 5, $this->y - 156, 'UTF-8');
        $page->drawText(__("Status : %1", $this->getCRBT()
            ->getStatus()), $x + 350, $this->y - 140, 'UTF-8');
        $page->drawText(__("Total Product Price : %1", $this->getCRBT()
                ->getPrice() . ' DH'), $x + 350, $this->y - 156, 'UTF-8');

        //****
        $product=$this->getPackageProduct();
        if ($this->getPackageProduct() !== NULL && count($this->getPackageProduct())) {
            $page->drawRectangle(30, $this->y - 165, $page->getWidth() - 30, $this->y - 190, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
            $style->setFont($font, 11);
            $page->setStyle($style);
            $page->drawText(__("Products"), $x + 5, $this->y - 180, 'UTF-8');
            $page->drawText(__("Products"), $x + 5, $this->y - 180, 'UTF-8');

            //**

            $page->drawRectangle(30, $this->y - 190, $page->getWidth() - 30, $this->y - 250, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
            $style->setFont($font, 10);
            $page->setStyle($style);

            $page->drawText(__("Title"), $x + 5, $this->y - 200, 'UTF-8');
            $page->drawText(__("Title"), $x + 5, $this->y - 200, 'UTF-8');

            $page->drawText(__("Unit Price"), $x + 300, $this->y - 200, 'UTF-8');
            $page->drawText(__("Unit Price"), $x + 300, $this->y - 200, 'UTF-8');

            $page->drawText(__("Quantity"), $x + 370, $this->y - 200, 'UTF-8');
            $page->drawText(__("Quantity"), $x + 370, $this->y - 200, 'UTF-8');

            $page->drawText(__("Product Total Price"), $x + 430, $this->y - 200, 'UTF-8');
            $page->drawText(__("Product Total Price"), $x + 430, $this->y - 200, 'UTF-8');

            foreach ($productPackage as $product) {
                $page->drawText(__(" %1", $product->getTitle()), $x + 5, $this->y - 216, 'UTF-8');
                $page->drawText(__(" %1", $product->getData('unitprice')), $x + 300, $this->y - 216, 'UTF-8');
                $page->drawText(__(" %1", $product->getPackageProductQty()), $x + 370, $this->y - 216, 'UTF-8');
                $page->drawText(__(" %1", $product->getTotalPrice()), $x + 430, $this->y - 216, 'UTF-8');
                $this->y = $this->y - 16;
            }
            $totalPrice = $this->getCRBT()
                    ->getPrice() + $this->getPackage()
                    ->getPrice();
            $page->drawText(__("Total Product Price : %1", $this->getCRBT()
                    ->getPrice() . ' DH'), $x + 370, $this->y - 240, 'UTF-8');
            $page->drawText(__("Shipping Charges : %1", $this->getPackage()
                    ->getPrice() . ' DH'), $x + 370, $this->y - 256, 'UTF-8');
            $page->drawText(__("Total Price : %1", $totalPrice . ' DH'), $x + 370, $this->y - 272, 'UTF-8');

       }
        $totalPriceSimple = $this->getCRBT()
                ->getPrice() + $this->getPackage()
                ->getPrice();
            $page->drawText(__("Product Price : %1", $this->getCRBT()
                    ->getPrice() . ' DH'), $x + 370, $this->y - 180, 'UTF-8');
            $page->drawText(__("Shipping Charges : %1", $this->getPackage()
                    ->getPrice() . ' DH'), $x + 370, $this->y - 196, 'UTF-8');
            $page->drawText(__("Total Price : %1", $totalPriceSimple . ' DH'), $x + 370, $this->y - 212, 'UTF-8');



        //        $page->drawText(__("PRODUCT NAME"), $x + 60, $this->y - 10, 'UTF-8');
        //        $page->drawText(__("PRODUCT PRICE"), $x + 200, $this->y - 10, 'UTF-8');
        //        $page->drawText(__("QTY"), $x + 310, $this->y - 10, 'UTF-8');
        //        $page->drawText(__("SUB TOTAL"), $x + 440, $this->y - 10, 'UTF-8');

        //        $style->setFont($font, 10);
        //        $page->setStyle($style);
        //        $add = 9;

        //        $page->drawText("$12.00", $x + 210, $this->y - 30, 'UTF-8');
        //        $page->drawText(10, $x + 330, $this->y - 30, 'UTF-8');
        //        $page->drawText("$120.00", $x + 470, $this->y - 30, 'UTF-8');
        //        $pro = "TEST product";
        //        $page->drawText($pro, $x + 65, $this->y - 30, 'UTF-8');

        //$page->drawRectangle(30, $this->y - 62, $page->getWidth() - 30, $this->y - 40, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);
        // $page->drawRectangle(30, $this->y - 62, $page->getWidth() - 30, $this->y - 100, \Zend_Pdf_Page::SHAPE_DRAW_STROKE);

        $style->setFont($font, 15);
        $page->setStyle($style);
        //$page->drawText(__("Total : %1", "$50.00"), $x + 435, $this->y - 85, 'UTF-8');

        $style->setFont($font, 10);
        $page->setStyle($style);
        //$page->drawText(__("Trust Parcel"), ($page->getWidth() / 2) - 50, $this->y - 200);

        $fileName = 'invoice.pdf';

        $this->fileFactory->create(
            $fileName,
            $pdf->render(),
            \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR, // this pdf will be saved in var directory with the name meetanshi.pdf
            'application/pdf'
        );
    }

}
